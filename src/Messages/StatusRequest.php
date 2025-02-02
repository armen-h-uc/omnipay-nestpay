<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class StatusRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $this->setStatus(true);
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return StatusResponse
     * @throws \JsonException
     */
    protected function createResponse($data): StatusResponse
    {
        $response = new StatusResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }


    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return ['Password'];
    }

    /**
     * @inheritDoc
     */
    public function getProcessName(): string
    {
        return 'Status';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return '';
    }
}
