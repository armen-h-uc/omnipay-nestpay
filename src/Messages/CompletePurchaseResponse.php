<?php

declare(strict_types=1);
/**
 * NestPay Complete Purchase Response
 */

namespace Omnipay\NestPay\Messages;

class CompletePurchaseResponse extends PurchaseResponse
{
    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        return $this->data['oid'] ?? null;
    }
}
