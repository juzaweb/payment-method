<?php

namespace Juzaweb\PaymentMethod\Contracts;

use Juzaweb\PaymentMethod\Models\PaymentMethod as PaymentMethodModel;
use Juzaweb\PaymentMethod\Support\PaymentMethodInterface;

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */
interface PaymentMethodManager
{
    /**
     * Register a new payment method.
     *
     * @param string $name description
     * @param string $class description
     * @return void
     */
    public function register(string $name, string $class): void;

    /**
     * Create a PaymentMethodInterface from the given PaymentMethodModel.
     *
     * @param PaymentMethodModel $paymentMethod The payment method model to be used
     * @throws \RuntimeException Payment method not found
     * @return PaymentMethodInterface
     */
    public function make(PaymentMethodModel $paymentMethod): PaymentMethodInterface;

    /**
     * purchase function.
     *
     * @param PaymentMethodModel $paymentMethod description
     * @param array $params description
     * @return PaymentMethodInterface
     */
    public function purchase(PaymentMethodModel $paymentMethod, array $params = []): PaymentMethodInterface;

    /**
     * A function that takes a PaymentMethodModel and an array of parameters
     *
     * @param PaymentMethodModel $paymentMethod The payment method model
     * @param array $params The parameters for the function
     * @return PaymentMethodInterface
     */
    public function completed(PaymentMethodModel $paymentMethod, array $params): PaymentMethodInterface;
}
