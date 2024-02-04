<?php

namespace Juzaweb\PaymentMethod\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],
            'payment_method' => [
                'required',
                'string',
                Rule::modelExists(PaymentMethod::class, 'type')
            ]
        ];
    }
}
