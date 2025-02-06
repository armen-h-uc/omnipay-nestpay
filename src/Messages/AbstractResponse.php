<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    /**
     * AbstractResponse constructor.
     *
     * @param RequestInterface $request
     * @param                  $data
     *
     * @throws \JsonException
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->data = (is_string($data)) ? json_decode(
            json_encode(
                (array)simplexml_load_string($data),
                JSON_THROW_ON_ERROR
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : $data;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->isSuccessful() ? $this->data['Response'] ?? null : $this->data['ErrMsg'];
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        $authCode = $this->data['AuthCode'] ?? $this->data['Extra']['AUTH_CODE'] ?? null;

        return $this->isSuccessful() ? $authCode : parent::getCode();
    }

    /**
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        if (isset($this->data['ProcReturnCode'])) {
            return (string)$this->data["ProcReturnCode"] === '00';
        }

        if (isset($this->data['Response'])) {
            return $this->data["Response"] === 'Approved';
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getTransactionReference(): ?string
    {
        return $this->data['TransId'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        return $this->data['oid'] ?? $this->data['OrderId'] ?? null;
    }
}
