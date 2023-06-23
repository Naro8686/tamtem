<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceOperation extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'payment_system',
        'payment_to',
        'status',
        'text',
        'request',
        'result',
        'decode_result',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
