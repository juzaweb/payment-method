<?php

namespace Juzaweb\PaymentMethod\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

class PaymentHistory extends Model
{
    protected $table = 'payment_method_payment_histories';

    protected $fillable = [
        'payment_method',
        'status',
        'data',
        'module_id',
        'module_type',
        'user_id',
        'payment_order_id',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method', 'type');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
