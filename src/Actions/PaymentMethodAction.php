<?php

namespace Juzaweb\PaymentMethod\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager;
use Juzaweb\PaymentMethod\PaymentMethods\Paypal;

class PaymentMethodAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'paymentMethodInit']);
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenus']);
    }

    public function paymentMethodInit(): void
    {
        app()->make(PaymentMethodManager::class)->register(
            'paypal',
            Paypal::class
        );
    }

    public function addAdminMenus(): void
    {
        // $this->registerAdminPage(
        //     'payment-methods',
        //     [
        //         'title' => trans('Payment Methods'),
        //         'menu' => [
        //             'icon' => 'fa fa-shopping-cart',
        //             'position' => 50,
        //         ]
        //     ]
        // );

        $this->registerAdminPage(
            'payment-methods',
            [
                'title' => trans('Payment Methods'),
                'menu' => [
                    'icon' => 'fa fa-credit-card',
                    'position' => 50,
                    //'parent' => 'payment-methods',
                ]
            ]
        );
    }
}
