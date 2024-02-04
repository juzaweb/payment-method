<?php

namespace Juzaweb\PaymentMethod\Models;

use Juzaweb\CMS\Models\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_method_payment_histories';

    protected $fillable = [
        'payment_method',
        'status',
        'data',
        'order_id',
        'order_type',
        'user_id',
    ];
}
