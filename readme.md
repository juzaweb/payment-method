## Features
- [x] Paypal Payment support
- [ ] Stripe Payment support

## Development

### Add a payment method

- Create class implement PaymentMethodInterface
```php
<?php
// PaymentMethodInterface interface
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
```
- Register payment method in PaymentMethodManager

In your HookAction handle
```php
use Juzaweb\PaymentMethod\Contracts\PaymentMethodManager;
//...

public function handle(): void
{
    $this->addAction(Action::INIT_ACTION, [$this, 'paymentMethodInit']);
}

public function paymentMethodInit(): void
{
    app()->make(PaymentMethodManager::class)->register(
        'paypal',
        Paypal::class
    );
}
```
