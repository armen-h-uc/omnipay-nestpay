<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class RefundRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Refund';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'Credit';
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount');

        $data['Type'] = $this->getProcessType();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $data['OrderId'] = $this->getTransactionId();
        $data['Total'] = $this->getAmount();
        $data['Currency'] = $this->getCurrencyNumeric();

        return $data;
    }

    /**
     * @param $data
     *
     * @return RefundResponse
     * @throws \JsonException
     */
    protected function createResponse($data): RefundResponse
    {
        return new RefundResponse($this, $data);
    }
}
