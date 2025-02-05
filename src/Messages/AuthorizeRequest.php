<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Exception;

class AuthorizeRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getSensitiveData(): array
    {
        return ['Number', 'Expires', 'Password'];
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Authorize';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'PreAuth';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        $data = $this->getSalesRequestParams();
        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @param $data
     * @return AuthorizeResponse
     * @throws \JsonException
     */
    protected function createResponse($data): AuthorizeResponse
    {
        $response = new AuthorizeResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
