<?php

namespace Juzaweb\PaymentMethod\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\PaymentMethod\Actions\ResourceAction;
use Juzaweb\PaymentMethod\Contracts\Payment as PaymentContract;
use Juzaweb\PaymentMethod\Support\Payment;

class PaymentMethodServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register([ResourceAction::class]);
    }

    public function register()
    {
        $this->app->singleton(PaymentContract::class, Payment::class);
    }
}
