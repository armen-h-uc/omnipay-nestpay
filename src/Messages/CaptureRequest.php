<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest
{
    /**
     * @return string[]
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
        return 'Capture';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'PostAuth';
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = $this->getSalesRequestParams();
        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @param $data
     * @return CaptureResponse
     * @throws \JsonException
     */
    protected function createResponse($data): CaptureResponse
    {
        $response = new CaptureResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
