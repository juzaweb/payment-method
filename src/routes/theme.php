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

Route::post('ajax/payment/purchase', [PaymentController::class, 'buy']);
Route::get('ajax/payment/cancel', [PaymentController::class, 'cancel']);
Route::get('ajax/payment/completed', [PaymentController::class, 'completed']);
