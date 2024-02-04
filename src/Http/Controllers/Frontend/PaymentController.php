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
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager;
use Juzaweb\PaymentMethod\Http\Requests\PaymentRequest;
use Juzaweb\PaymentMethod\Models\PaymentHistory;
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
                    'redirect' => action([static::class, 'cancel'], ['module' => $module]),
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
                    'cancelUrl' => action([static::class, 'cancel'], ['module' => $module]),
                    'returnUrl' => action([static::class, 'completed'], ['method' => $paymentMethod->type, 'module' => $module]),
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

    public function completed(Request $request, string $module, string $method): RedirectResponse
    {
        $registedModule = $this->paymentMethodManager->getModule($module);
        $paymentMethod = PaymentMethod::findByType($method);

        if ($paymentMethod === null) {
            return $this->error(
                [
                    'redirect' => action([static::class, 'cancel'], ['module' => $module]),
                    'message' => __('Payment method not found.'),
                ]
            );
        }

        $helper = $this->paymentMethodManager->make($paymentMethod);

        if ($helper?->completed($request->all())) {
            if (PaymentHistory::where(['payment_id' => $helper->getPaymentId(), 'module_type' => $module])->exists()) {
                return redirect()->to($this->getThanksPageURL($module));
            }

            DB::transaction(
                function () use ($helper, $method, $module, $request, $registedModule) {
                    $hanlder = app()->make($registedModule->get('handler'));
                    $completed = $hanlder->completed($request->all());

                    PaymentHistory::create(
                        [
                            'payment_method' => $method,
                            'module_id' => $completed->id,
                            'module_type' => $module,
                            'user_id' => $request->user()->id,
                            'payment_id' => $helper->getPaymentId(),
                            'amount' => $helper->getAmount(),
                        ]
                    );
                }
            );
        }

        return redirect()->to($this->getThanksPageURL($module));
    }

    protected function getThanksPageURL(string $module): string
    {
        $module = $this->paymentMethodManager->getModule($module);

        return url($module->get('thanks_page_url', '/profile'));
    }
}
