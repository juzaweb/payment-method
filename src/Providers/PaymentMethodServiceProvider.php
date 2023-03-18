<?php

namespace Juzaweb\PaymentMethod\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\PaymentMethod\Actions\ResourceAction;

class PaymentMethodServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register([ResourceAction::class]);
    }

    public function register()
    {
        //
    }
}
