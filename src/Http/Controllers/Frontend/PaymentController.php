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
use Juzaweb\CMS\Http\Controllers\FrontendController;
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
        $paymentMethod = PaymentMethod::findByType($request->input('payment_method'));

        if ($paymentMethod === null) {
            return $this->error(
                [
                    'redirect' => action([static::class, 'cancel']),
                    'message' => __('Payment method not found.'),
                ]
            );
        }

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
                $this->getThanksPageURL($module);

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
                    'redirect' => $this->getThanksPageURL($module),
                    'message' => __('Cannot get payment url.'),
                ]
            );
        }
    }

    public function cancel(string $module): RedirectResponse
    {
        return redirect()->to($this->getThanksPageURL($module));
    }

    public function completed(Request $request, string $module): RedirectResponse
    {
        $helper = $this->orderManager->find($request->input('order'));
        $order = $helper->getOrder();

        if ($order->isPaymentCompleted()) {
            return redirect()->to($this->getThanksPageURL($module));
        }

        if ($helper?->completed($request->all())) {
            //
        }

        return redirect()->to($this->getThanksPageURL($module));
    }

    protected function getThanksPageURL(string $module): string
    {
        return url('profile/buy-credit');
    }
}
