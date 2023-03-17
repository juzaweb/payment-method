<?php

namespace Juzaweb\PaymentMethod\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class PaymentMethodController extends BackendController
{
    public function index()
    {
        //

        return view(
            'jupa::index',
            [
                'title' => 'Title Page',
            ]
        );
    }
}
