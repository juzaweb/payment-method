<?php

namespace Juzaweb\PaymentMethod\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\PaymentMethod\Http\Datatables\PaymentMethodDatatable;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

class PaymentMethodController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected string $viewPrefix = 'payment_method::backend.payment_method';

    protected function getDataTable(...$params): PaymentMethodDatatable
    {
        return new PaymentMethodDatatable();
    }

    protected function validator(array $attributes, ...$params): \Illuminate\Validation\Validator
    {
        $types = config('ecommerce.payment_methods');
        $types = array_keys($types);

        return Validator::make(
            $attributes,
            [
                'type' => [
                    'required_if:id,',
                    Rule::in($types)
                ],
                'name' => [
                    'required'
                ]
            ]
        );
    }

    protected function getModel(...$params): string
    {
        return PaymentMethod::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('Payment methods');
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        $data['methods'] = [];
        return $data;
    }

    protected function parseDataForSave(array $attributes, ...$params): array
    {
        $attributes['active'] = $attributes['active'] ?? 0;

        return $attributes;
    }
}
