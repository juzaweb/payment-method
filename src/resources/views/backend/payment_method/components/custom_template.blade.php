{{ Field::textarea(
    trans('payment_method::content.payment_description'),
    'data[description]',
    [
        'value' => $data['description'] ?? ''
    ]
) }}