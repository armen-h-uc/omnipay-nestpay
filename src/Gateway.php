<?php

declare(strict_types=1);
/**
 * NestPay Class using API
 */

namespace Omnipay\NestPay;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\NestPay\Messages\CompletePurchaseRequest;
use Omnipay\NestPay\Messages\PurchaseRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\NestPay\Messages\AuthorizeRequest;
use Omnipay\NestPay\Messages\CaptureRequest;
use Omnipay\NestPay\Messages\RefundRequest;
use Omnipay\NestPay\Messages\StatusRequest;
use Omnipay\NestPay\Messages\VoidRequest;

/**
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
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
     * @return Gateway
     */
    public function getStoreKey(): string
    {
        return $this->getParameter('storeKey');
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function authorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function capture(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function void(array $parameters = []): RequestInterface
    {
        return $this->createRequest(VoidRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return Messages\AbstractRequest|RequestInterface
     */
    public function status(array $parameters = []): RequestInterface
    {
        return $this->createRequest(StatusRequest::class, $parameters);
    }
}
