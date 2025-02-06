<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class CancelRequest extends AbstractRequest
{
    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Void';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'Void';
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data['Type'] = $this->getProcessType();
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();

        return $data;
    }

    /**
     * @param $data
     * @return CancelResponse
     * @throws \JsonException
     */
    protected function createResponse($data): CancelResponse
    {
        return new CancelResponse($this, $data);
    }
}
