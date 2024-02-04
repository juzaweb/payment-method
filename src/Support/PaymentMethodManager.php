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

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager as PaymentMethodManagerContract;
use Juzaweb\PaymentMethod\Models\PaymentMethod as PaymentMethodModel;
use RuntimeException;

class PaymentMethodManager implements PaymentMethodManagerContract
{
    protected static array $paymentMethods = [];

    protected static array $modules = [];

    public function register(string $name, string|array $class): void
    {
        static::$paymentMethods[$name] = $class;
    }

    public function getPaymentMethods(): Collection
    {
        return collect(static::$paymentMethods)
            ->map(
                function ($class, $key) {
                    return [
                        'handle' => $class,
                        'key' => $key,
                        'name' => Str::ucfirst($key),
                    ];
                }
            );
    }

    public function registerModule(string $key, array $args): void
    {
        if (!isset($args['handler'])) {
            throw new RuntimeException('Module handler is required');
        }

        static::$modules[$key] = new Collection($args);
    }

    public function getModule(string $key): Collection
    {
        return static::$modules[$key];
    }

    public function getModules(): Collection
    {
        return new Collection(static::$modules);
    }

    public function make(PaymentMethodModel $paymentMethod): PaymentMethodInterface
    {
        if (isset(static::$paymentMethods[$paymentMethod->type])) {
            return app()->make(static::$paymentMethods[$paymentMethod->type], ['paymentMethod' => $paymentMethod]);
        }

        throw new RuntimeException('Payment method not found');
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
