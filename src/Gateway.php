<?php

declare(strict_types=1);

namespace Omnipay\NestPay;

use Omnipay\NestPay\Messages\CancelRequest;
use Omnipay\NestPay\Messages\CompletePurchaseRequest;
use Omnipay\NestPay\Messages\FetchTransactionRequest;
use Omnipay\NestPay\Messages\PurchaseRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\NestPay\Messages\RefundRequest;

class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'NestPay';
    }

    public function getDefaultParameters(): array
    {
        return [
            'bank' => '',
            'clientId' => '',
            'username' => '',
            'storeKey' => '',
            'password' => ''
        ];
    }

    /**
     * @return string
     */
    public function getBank(): string
    {
        return $this->getParameter('bank');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setBank(string $value): Gateway
    {
        return $this->setParameter('bank', $value);
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->getParameter('username');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setUserName(string $value): Gateway
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setPassword(string $value): Gateway
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setClientId(string $value): Gateway
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @param string $storeKey
     * @return Gateway
     */
    public function setStoreKey(string $storeKey): Gateway
    {
        return $this->setParameter('storeKey', $storeKey);
    }

    /**
     * @return string
     */
    public function getStoreKey(): string
    {
        return $this->getParameter('storeKey');
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function cancel(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CancelRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function fetchTransaction(array $parameters = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }
}
