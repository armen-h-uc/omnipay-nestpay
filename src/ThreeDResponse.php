<?php

declare(strict_types=1);

namespace Omnipay\NestPay;

class ThreeDResponse
{
    public string|null $mdStatus;
    public string|null $clientId;
    public string|null $amount;
    public string|null $currency;
    public string|null $xid;
    public string|null $oid;
    public string|null $cavv;
    public string|null $eci;
    public string|null $md;
    public string|null $rnd;
    public string|null $hashParams;
    public string|null $hashParamsVal;
    public string|null $hash;
    public string|null $groupId;
    public string|null $transId;
    public string|null $userId;
    public string|null $ipAddress;
    public string|null $installment;

    /**
     * @return string|null
     */
    public function getMdStatus(): ?string
    {
        return $this->mdStatus;
    }

    /**
     * @param string|null $mdStatus
     *
     * @return void
     */
    public function setMdStatus(?string $mdStatus): void
    {
        $this->mdStatus = $mdStatus;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @param string|null $clientId
     *
     * @return void
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string|null $amount
     *
     * @return void
     */
    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     *
     * @return void
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string|null
     */
    public function getXid(): ?string
    {
        return $this->xid;
    }

    /**
     * @param string|null $xid
     *
     * @return void
     */
    public function setXid(?string $xid): void
    {
        $this->xid = $xid;
    }

    /**
     * @return string|null
     */
    public function getOid(): ?string
    {
        return $this->oid;
    }

    /**
     * @param string|null $oid
     *
     * @return void
     */
    public function setOid(?string $oid): void
    {
        $this->oid = $oid;
    }

    /**
     * @return string|null
     */
    public function getCavv(): ?string
    {
        return $this->cavv;
    }

    /**
     * @param string|null $cavv
     *
     * @return void
     */
    public function setCavv(?string $cavv): void
    {
        $this->cavv = $cavv;
    }

    /**
     * @return string|null
     */
    public function getEci(): ?string
    {
        return $this->eci;
    }

    /**
     * @param string|null $eci
     *
     * @return void
     */
    public function setEci(?string $eci): void
    {
        $this->eci = $eci;
    }

    /**
     * @return string|null
     */
    public function getMd(): ?string
    {
        return $this->md;
    }

    /**
     * @param string|null $md
     *
     * @return void
     */
    public function setMd(?string $md): void
    {
        $this->md = $md;
    }

    /**
     * @return string|null
     */
    public function getRnd(): ?string
    {
        return $this->rnd;
    }

    /**
     * @param string|null $rnd
     *
     * @return void
     */
    public function setRnd(?string $rnd): void
    {
        $this->rnd = $rnd;
    }

    /**
     * @return string|null
     */
    public function getHashParams(): ?string
    {
        return $this->hashParams;
    }

    /**
     * @param string|null $hashParams
     *
     * @return void
     */
    public function setHashParams(?string $hashParams): void
    {
        $this->hashParams = $hashParams;
    }

    /**
     * @return string|null
     */
    public function getHashParamsVal(): ?string
    {
        return $this->hashParamsVal;
    }

    /**
     * @param string|null $hashParamsVal
     *
     * @return void
     */
    public function setHashParamsVal(?string $hashParamsVal): void
    {
        $this->hashParamsVal = $hashParamsVal;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string|null $hash
     *
     * @return void
     */
    public function setHash(?string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return string|null
     */
    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    /**
     * @param string|null $groupId
     *
     * @return void
     */
    public function setGroupId(?string $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string|null
     */
    public function getTransId(): ?string
    {
        return $this->transId;
    }

    /**
     * @param string|null $transId
     *
     * @return void
     */
    public function setTransId(?string $transId): void
    {
        $this->transId = $transId;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @param string|null $userId
     *
     * @return void
     */
    public function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @param string|null $ipAddress
     *
     * @return void
     */
    public function setIpAddress(?string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string|null
     */
    public function getInstallment(): ?string
    {
        return $this->installment;
    }

    /**
     * @param string|null $installment
     *
     * @return void
     */
    public function setInstallment(?string $installment): void
    {
        $this->installment = $installment;
    }
}
