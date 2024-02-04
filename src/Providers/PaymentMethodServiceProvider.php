<?php

namespace Juzaweb\PaymentMethod\Providers;

use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\PaymentMethod\Actions\PaymentMethodAction;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager as PaymentMethodManagerContract;
use Juzaweb\PaymentMethod\Support\PaymentMethodManager;

class PaymentMethodServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerHookActions([PaymentMethodAction::class]);
    }

    public function register(): void
    {
        $this->app->singleton(
            PaymentMethodManagerContract::class,
            PaymentMethodManager::class
        );
    }
}
