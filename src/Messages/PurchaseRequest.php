<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
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
        return 'Purchase3D';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'Auth';
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->setAction('3d');

        return $this->getPurchase3DHostingData();
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    public function sendData($data): ResponseInterface
    {
        return $this->response = $this->createResponse($data);
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    protected function createResponse($data): ResponseInterface
    {
        return new PurchaseResponse($this, $data);
    }
}
