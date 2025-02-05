<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{
    private const PAYMENT_TYPE_3D = "3d";
    private const PAYMENT_TYPE_3D_HOSTING = "3d_pay_hosting";

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
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            return 'Purchase3D';
        }
        return 'Purchase';
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
        $data = $this->getPurchase3DHostingData();

        $this->setRequestParams($data);

        return $data;
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
        $response = new Purchase3DResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
