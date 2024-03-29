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

interface PaymentMethodInterface
{
    public function purchase(array $params): PaymentMethodInterface;

    public function completed(array $params): PaymentMethodInterface;

    public function isSuccessful(): bool;

    public function isRedirect(): bool;

    public function getRedirectURL(): null|string;

    public function getMessage(): string;

    public function getPaymentId(): string;

    public function setPaymentId(string $paymentId): static;

    public function getAmount(): float;

    public function setAmount(float $amount): static;
}
