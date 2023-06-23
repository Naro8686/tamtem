<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticRequestsLog extends Model
{

    protected $table = 'log_statistic_requests';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'post_data', 'return_data','result', 'status', 'request_date', 'text',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['request_date'];
   
    public static function lastRequestData()
    { 
        if($last_request_data = self::select('request_date')->orderBy('created_at', 'DESC')->first()){
            return $last_request_data->request_date->format('Y-m-d H:i:s');
        }
        else{
            return \Carbon\Carbon::now()->subYears(1)->format('Y-m-d H:i:s');
        }
    }
}
