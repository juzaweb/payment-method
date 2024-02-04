{{
    Field::select(
        trans('payment_method::content.mode'),
        'data[mode]',
        [
            'value' => $data['mode'] ?? '',
            'options' => [
                'sandbox' => trans('payment_method::content.sandbox'),
                'live' => trans('payment_method::content.live'),
            ],
        ]
    )
}}

{{ Field::text(
    trans('payment_method::content.sandbox_client_id'),
    'data[sandbox_client_id]',
    [
        'value' => $data['sandbox_client_id'] ?? ''
    ]
) }}

{{ Field::text(
    trans('payment_method::content.sandbox_secret'),
    'data[sandbox_secret]',
    [
        'value' => $data['sandbox_secret'] ?? ''
    ]
) }}

{{ Field::text(
    trans('payment_method::content.live_client_id'),
    'data[live_client_id]',
    [
        'value' => $data['live_client_id'] ?? ''
    ]
) }}

{{ Field::text(
    trans('payment_method::content.live_secret'),
    'data[live_secret]',
    [
        'value' => $data['live_secret'] ?? ''
    ]
) }}