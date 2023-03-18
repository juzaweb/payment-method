<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

use Juzaweb\PaymentMethod\Http\Controllers\PaymentMethodController;

Route::jwResource(
    'payment-methods/{module}',
    PaymentMethodController::class,
    [
        'name' => 'payment_methods'
    ]
);
