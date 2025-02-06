<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class FetchTransactionRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Status';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $this->setOrderStatusQuery(true);

        return $data;
    }

    /**
     * @param $data
     *
     * @return FetchTransactionResponse
     * @throws \JsonException
     */
    protected function createResponse($data): FetchTransactionResponse
    {
        return new FetchTransactionResponse($this, $data);
    }
}
