<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class PurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isRedirect(): bool
    {
        return true;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->data['redirectUrl'];
    }

    /**
     * @return string
     */
    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getRedirectData(): array
    {
        return $this->getData();
    }
}
