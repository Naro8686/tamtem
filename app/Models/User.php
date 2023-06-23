<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    // роли юзеров
    const ROLE_CLIENT        = 1;   // обычный пользователь сайта
    const ROLE_CLIENT_WORKER = 2;   // помошник пользователя сайта
    const ROLE_ADMINISTRATOR = 10;  // администратор системы
    const ROLE_MODERATOR     = 11;  // модератор
    const ROLES = [
        self::ROLE_CLIENT,
        self::ROLE_CLIENT_WORKER,
        self::ROLE_ADMINISTRATOR,
        self::ROLE_MODERATOR,
    ];


    // статусы юзеров
    const USER_STATUS_REGISTRED = 0;  // зарегистрирован
    const USER_STATUS_APPROVE   = 1;  // обычный пользователь сайта
    const USER_STATUS_BANNED    = -1; // забанен
    const USER_STATUS_ARCHIVE   = -2; // удален
    const STATUSES = [
        self::USER_STATUS_REGISTRED,
        self::USER_STATUS_APPROVE,
        self::USER_STATUS_BANNED,
        self::USER_STATUS_ARCHIVE,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'unique_id', 
        'status', 
        'role', 
        'phone',
        'photo',
        'privilege_id',
        'ballance',
        'points',
        'points_from_agents',
        'referal_url',
        'from_agent',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //static protected $sortable = ['id', 'name', 'email', 'role', 'status', 'unique_id'];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
    * Override parent boot and Call deleting event
    *
    * @return void
    */
    protected static function boot() 
    {
        parent::boot();
    
        static::deleting(function($user) {
            foreach ($user->organizations()->get() as $organization) {
                $organization->delete();
            }
        });

        static::restored(function($user) {
            foreach ($user->organizations()->withTrashed()->get() as $organization) {
                $organization->restore();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizations()
    {
        return $this->hasMany(\App\Models\Organization::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizationsActive()
    {
        return $this->organizations()->where('status', '=', \App\Models\Organization::ORGANIZATION_STATUS_ACTIVATED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function isMiOrganization($organization_id)
    { 
        if ($this->organizations()->where('id', '=', $organization_id)->first()) {
            return true;
        }
        return false;
    } 

    public function scopeActive($query)
    { 
            return $query->where('status', '=', self::USER_STATUS_APPROVE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function privilege()
    {
        return $this->hasOne(\App\Models\Privileges::class, 'id', 'privilege_id');
    }

    /**
     * Пользователь забанен
     *
     * @return boolean
     */
    public function isBanned()
    {
        if ($this->status === self::USER_STATUS_BANNED) {
            return true;
        }
        return false;
    }

    /**
     * Пользователь адмнистратор
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->role === self::ROLE_ADMINISTRATOR) {
            return true;
        }
        return false;
    }

     /**
     * Create api access token
     */
    public function rollApiKey()
    {
        do {
            $this->api_token = str_random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

    /**
     * Create confirm access token
     */
    public function rollConfirmKey()
    {
        do {
            $this->register_confirm_token = str_random(60);
        } while ($this->where('register_confirm_token', $this->register_confirm_token)->exists());
        $this->save();
    }

    public static function generateUniqueUserIdNumber() {
        
        $number = mt_rand(1000000, 9999999); // better than rand()

        if (self::barcodeNumberExists($number)) {
            return self::generateUniqueUserIdNumber();
        }
 
        return $number;
    }
    
    public static function barcodeNumberExists($number) {
        return User::whereUniqueId($number)->exists();
    }

    public function login() {

        Auth::login($this); 

        if(Auth::user()) {
            $this->rollApiKey();
            return Auth::user()->api_token;
        }
        return null;
    }

    public function logout() {

        if(Auth::user()) {
            $this->api_token = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function refGenerateFromMeAndSave()
    {

        $parametersToRefUrl = [
            'agent_id' =>$this->unique_id, 
        ];

        $refUrl =  asset('/') . "ref/" .   base64_encode(http_build_query($parametersToRefUrl));

        $this->referal_url = $refUrl;
        $this->save();
         
        return $this;
    }

    /**
     * генерация рефералки и ее возврат при регистрации
     *
     * @param  mixed $uniqueId
     *
     * @return void
     */
    public static function refGenerateFromMeFromUniqueId($uniqueId)
    {

        $parametersToRefUrl = [
            'agent_id' => $uniqueId, 
        ];

        $refUrl =  asset('/') . "ref/" . base64_encode(http_build_query($parametersToRefUrl));

        return $refUrl;
    }
}
