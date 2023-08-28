<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Support;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Contracts\GlobalDataContract as GlobalData;
use Juzaweb\CMS\Contracts\HookActionContract as HookAction;
use Juzaweb\PaymentMethod\Contracts\Payment as PaymentContract;
use Juzaweb\PaymentMethod\Interfaces\PaymentMethodInterface;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

class Payment implements PaymentContract
{
    public function __construct(protected HookAction $hookAction, protected GlobalData $globalData)
    {
    }

    public function registerPaymentMethod(string|PaymentMethodInterface $method)
    {
        if (!$method instanceof PaymentMethodInterface) {
            $method = app($method);
        }

        $args = [
            'key' => $method->getName(),
            'label' => $method->getLabel(),
            'class' => get_class($method),
            'configs' => $method->getConfigs(),
        ];

        $this->globalData->set("payment_methods.{$args['key']}", new Collection($args));
    }

    public function make(PaymentMethod $paymentMethod): PaymentMethodInterface
    {
        return match ($paymentMethod->type) {
            'paypal' => new Paypal($paymentMethod),
            default => new Cod($paymentMethod),
        };
    }

    public function purchase(PaymentMethod $paymentMethod, array $params = []): PaymentMethodInterface
    {
        return $this->make($paymentMethod)->purchase($params);
    }

    public function completed(PaymentMethod $paymentMethod, array $params): PaymentMethodInterface
    {
        return $this->make($paymentMethod)->completed($params);
    }
}
