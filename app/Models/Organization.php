<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    // статусы юзеров
    const ORGANIZATION_STATUS_UNACTIVATED = 0;  // организация создана генерацией реферальной ссылки
    const ORGANIZATION_STATUS_ACTIVATED   = 1;  // организация активрована для агента переходом клиента по ссылке
    const ORGANIZATION_STATUS_BANNED    = -1; // забанена
    const ORGANIZATION_STATUS_ARCHIVE   = -2; // удалена
    const STATUSES = [
        self::ORGANIZATION_STATUS_UNACTIVATED,
        self::ORGANIZATION_STATUS_ACTIVATED,
        self::ORGANIZATION_STATUS_BANNED,
        self::ORGANIZATION_STATUS_ARCHIVE,
    ];

    protected $table = 'organizations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'inn', 
        'name', 
        'status', 
        'referal_url', 
        'parameters_url', 
        'category_name', 
        'points_buy_bid', 
        'points_set_winner', 
        'points_response', 
        'response_ballance', 
        'activated_at', 
        'before_to_at',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at', 'activated_at', 'before_to_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Организация активирована переходом по реферальной ссылке
     *
     * @return boolean
     */
    public function isActivated()
    {
        if ($this->role === self::ORGANIZATION_STATUS_ACTIVATED) {
            return true;
        }
        return false;
    }
}