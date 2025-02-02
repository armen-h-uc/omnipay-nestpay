<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class VoidRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['Type'] = $this->getProcessType();
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

        $this->setRequestParams($data);
        return $data;
    }

    /**
     * @param $data
     * @return VoidResponse
     * @throws \JsonException
     */
    protected function createResponse($data): VoidResponse
    {
        $response = new VoidResponse($this, $data);
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
        return 'Void';
    }

    /**
     * @inheritDoc
     */
    public function getProcessType(): string
    {
        return 'Void';
    }
}
