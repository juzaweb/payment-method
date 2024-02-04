<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Abstracts;

use Juzaweb\PaymentMethod\Models\PaymentMethod;
use Juzaweb\PaymentMethod\Support\PaymentMethodInterface;

abstract class PaymentMethodAbstract
{
    protected PaymentMethod $paymentMethod;

    protected bool $redirect = false;

    protected bool $successful = false;

    protected string $redirectURL = '';

    protected string $paymentId;

    protected float $amount;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    abstract public function purchase(array $params): PaymentMethodInterface;

    abstract public function completed(array $params): PaymentMethodInterface;

    public function isRedirect(): bool
    {
        return $this->redirect;
    }

    public function getRedirectURL(): null|string
    {
        if ($this->isRedirect()) {
            return $this->redirectURL;
        }

        return null;
    }

    public function getMessage(): string
    {
        return __('Thank you for your order.');
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function setPaymentId(string $paymentId): static
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    protected function setRedirectURL(string $url): void
    {
        $this->redirectURL = $url;
    }

    protected function setRedirect(bool $redirect): void
    {
        $this->redirect = $redirect;
    }
}
