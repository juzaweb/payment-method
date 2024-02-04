<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Http\Controllers\Frontend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Juzaweb\CMS\Events\EmailHook;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Ecommerce\Events\PaymentSuccess;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager;
use Juzaweb\PaymentMethod\Http\Requests\PaymentRequest;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

class PaymentController extends FrontendController
{
    public function __construct(
        protected PaymentMethodManager $paymentMethodManager
    ) {
    }

    public function buy(PaymentRequest $request, string $module): JsonResponse|RedirectResponse
    {
        $paymentMethod = PaymentMethod::find($request->input('payment_method'));

        try {
            $purchase = $this->paymentMethodManager->purchase(
                $paymentMethod,
                [
                    'amount' => $request->input('amount'),
                    'currency' => 'USD',
                    'cancelUrl' => action([static::class, 'cancel']),
                    'returnUrl' => action([static::class, 'completed']),
                ]
            );

            $redirect = $purchase->isRedirect() ?
                $purchase->getRedirectURL() :
                $this->getThanksPageURL();

            return $this->success(
                [
                    'redirect' => $redirect,
                    'message' => trans('Thank you for your order.'),
                ]
            );
        } catch (\Exception $e) {
            report($e);

            return $this->error(
                [
                    'redirect' => $this->getThanksPageURL(),
                    'message' => 'Cannot get payment url.',
                ]
            );
        }
    }

    public function cancel(string $module): RedirectResponse
    {
        return redirect()->to($this->getThanksPageURL());
    }

    public function completed(Request $request, string $module): RedirectResponse
    {
        $helper = $this->orderManager->find($request->input('order'));
        $order = $helper->getOrder();

        if ($order->isPaymentCompleted()) {
            return redirect()->to($this->getThanksPageURL($order));
        }

        if ($helper?->completed($request->all())) {
            $params = apply_filters(
                'ecom_payment_success_email_params',
                [
                    'name' => $helper->getOrder()?->user->name,
                    'email' => $helper->getOrder()?->user->email,
                    'order_code' => $helper->getOrder()->code,
                ],
                $order?->user,
                $order
            );

            if ($order?->user->email) {
                event(
                    new EmailHook(
                        'payment_success',
                        [
                            'to' => $order->user->email,
                            'params' => $params,
                        ]
                    )
                );
            }

            event(new PaymentSuccess($order));
        }

        return redirect()->to($this->getThanksPageURL());
    }

    protected function getThanksPageURL(): string
    {
        return url('profile/buy-credit');
    }
}
