<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Traits;

trait ParametersTrait
{
    /**
     * @param array $responseData
     *
     * @return void
     */
    public function setResponseData(array $responseData): void
    {
        $this->setParameter('responseData', $responseData);
    }

    /**
     * @return array|null
     */
    public function getResponseData(): ?array
    {
        return $this->getParameter('responseData');
    }

    /**
     * @return string|null
     */
    public function getStoreKey(): ?string
    {
        return $this->getParameter('storeKey');
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setStoreKey(string $value): void
    {
        $this->setParameter('storeKey', $value);
    }

    /**
     * @return string|null
     */
    public function getMoneyPoints(): ?string
    {
        return $this->getParameter('moneypoints');
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setMoneyPoints(string $value): void
    {
        $this->setParameter('moneypoints', $value);
    }

    /**
     * @return string|null
     */
    public function getStoreType(): ?string
    {
        return $this->getParameter('storetype');
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setStoreType(string $value): void
    {
        $this->setParameter('storetype', $value);
    }

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {
        return $this->getParameter('lang');
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setLang(string $value): void
    {
        $this->setParameter('lang', $value);
    }

    /**
     * @return string|null
     */
    public function getRefreshtime(): ?string
    {
        return $this->getParameter('refreshtime') ?? '30';
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function setRefreshtime($value): void
    {
        $this->setParameter('refreshtime', $value);
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->getParameter('companyName');
    }

    /**
     * @param string $companyName
     *
     * @return void
     */
    public function setCompanyName(string $companyName): void
    {
        $this->setParameter('companyName', $companyName);
    }

    /**
     * @param string $customEndPoint
     *
     * @return void
     */
    public function setCustomEndpoint(string $customEndPoint): void
    {
        $this->setParameter('customEndPoint', $customEndPoint);
    }

    /**
     * @return string|null
     */
    public function getCustomEndpoint(): ?string
    {
        return $this->getParameter('customEndPoint');
    }
}
