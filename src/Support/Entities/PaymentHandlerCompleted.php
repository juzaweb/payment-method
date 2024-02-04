<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\PaymentMethod\Support\Entities;

class PaymentHandlerCompleted
{
    public static function make(int $moduleId, string $paymentId, float $amount): static
    {
        return new static($moduleId);
    }

    public function __construct(protected int $moduleId)
    {
    }

    public function getModuleId(): int|string
    {
        return $this->moduleId;
    }
}
