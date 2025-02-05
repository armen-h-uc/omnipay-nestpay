<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class RefundRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return ['Password'];
    }

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

        $this->setRequestParams($data);

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
        $response = new RefundResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
