<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\PaymentMethod\Http\Controllers\Frontend\PaymentController;

Route::post('ajax/payment/{module}/purchase', [PaymentController::class, 'buy']);
Route::get('ajax/payment/{module}/cancel', [PaymentController::class, 'cancel']);
Route::get('ajax/payment/{module}/completed', [PaymentController::class, 'completed']);
