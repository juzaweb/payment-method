<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Support;

use Juzaweb\PaymentMethod\Models\PaymentMethod as PaymentMethodModel;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager as PaymentMethodManagerContract;

class PaymentMethodManager implements PaymentMethodManagerContract
{
    protected static array $paymentMethods = [];

    public function register(string $name, string $class): void
    {
        static::$paymentMethods[$name] = $class;
    }

    public function make(PaymentMethodModel $paymentMethod): PaymentMethodInterface
    {
        if (isset(static::$paymentMethods[$paymentMethod->type])) {
            return app()->make(static::$paymentMethods[$paymentMethod->type], ['paymentMethod' => $paymentMethod]);
        }

        throw new \RuntimeException('Payment method not found');
    }

    public function purchase(PaymentMethodModel $paymentMethod, array $params = []): PaymentMethodInterface
    {
        return $this->make($paymentMethod)->purchase($params);
    }

    public function completed(PaymentMethodModel $paymentMethod, array $params): PaymentMethodInterface
    {
        return $this->make($paymentMethod)->completed($params);
    }
}
