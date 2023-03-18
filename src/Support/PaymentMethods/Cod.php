<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\PaymentMethod\Support\PaymentMethods;

use Juzaweb\Ecommerce\Abstracts\PaymentMethodAbstract;
use Juzaweb\PaymentMethod\Interfaces\PaymentMethodInterface;

class Cod extends PaymentMethodAbstract implements PaymentMethodInterface
{
    public function purchase(array $params): PaymentMethodInterface
    {
        return $this;
    }

    public function isRedirect(): bool
    {
        return false;
    }

    public function completed(array $params): PaymentMethodInterface
    {
        // TODO: Implement completed() method.
    }

    public function isSuccessful(): bool
    {
        // TODO: Implement isSuccessful() method.
    }
}
