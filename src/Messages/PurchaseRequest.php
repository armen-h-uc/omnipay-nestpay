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
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        if ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D_HOSTING) {
            $this->setAction('3d');
            $data = $this->getPurchase3DHostingData();
        } elseif ($this->getPaymentMethod() === self::PAYMENT_TYPE_3D) {
            $this->setAction('3d');
            $data = $this->getPurchase3DData();
        } else {
            $data = $this->getSalesRequestParams();
        }

        $this->setRequestParams($data);

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return ResponseInterface
     * @throws InvalidResponseException
     */
    public function sendData($data): ResponseInterface
    {
        if (in_array($this->getPaymentMethod(), [self::PAYMENT_TYPE_3D, self::PAYMENT_TYPE_3D_HOSTING])) {
            return $this->response = $this->createResponse($data, Purchase3DResponse::class);
        }

        return parent::sendData($data);
    }

    /**
     * @param $responseClass
     * @param $data
     *
     * @return ResponseInterface
     */
    protected function createResponse($data, $responseClass = null): ResponseInterface
    {
        $class = $responseClass ?? PurchaseResponse::class;

        $response = new $class($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}
