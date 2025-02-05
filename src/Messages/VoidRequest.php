<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

class VoidRequest extends AbstractRequest
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
}
