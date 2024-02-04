<?php

namespace Juzaweb\PaymentMethod\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

class PaymentMethodDatatable extends DataTable
{
    public function columns(): array
    {
        return [
            'name' => [
                'label' => trans('payment_method::content.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'type' => [
                'label' => trans('payment_method::content.method'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return trans("payment_method::content.data.payment_methods.{$value}");
                }
            ],
            'active' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.active',
                        compact('row')
                    )->render();
                }
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '20%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    public function query(array $data): \Illuminate\Contracts\Database\Query\Builder
    {
        $query = PaymentMethod::select(
            [
                'id',
                'name',
                'type',
                'active',
                'created_at'
            ]
        );

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
            });
        }

        if ($type = Arr::get($data, 'type')) {
            $query->where('type', '=', $type);
        }

        return $query;
    }

    public function bulkActions($action, $ids): void
    {
        switch ($action) {
            case 'delete':
                PaymentMethod::destroy($ids);
                break;
        }
    }
}
