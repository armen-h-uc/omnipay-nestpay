<?php

declare(strict_types=1);

namespace Omnipay\NestPay;

class ThreeDResponse
{
    public $mdStatus;
    public $clientId;
    public $amount;
    public $currency;
    public $xid;
    public $oid;
    public $cavv;
    public $eci;
    public $md;
    public $rnd;
    public $hashParams;
    public $hashParamsVal;
    public $hash;
    public $groupId;
    public $transId;
    public $userId;
    public $ipAddress;
    public $installment;

    /**
     * @return mixed
     */
    public function getMdStatus()
    {
        return $this->mdStatus;
    }

    /**
     * @param mixed $mdStatus
     */
    public function setMdStatus($mdStatus): void
    {
        $this->mdStatus = $mdStatus;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }


    /**
     * @return mixed
     */
    public function getXid()
    {
        return $this->xid;
    }

    /**
     * @param mixed $xid
     */
    public function setXid($xid): void
    {
        $this->xid = $xid;
    }

    /**
     * @return mixed
     */
    public function getOid()
    {
        return $this->oid;
    }

    /**
     * @param mixed $oid
     */
    public function setOid($oid): void
    {
        $this->oid = $oid;
    }

    /**
     * @return mixed
     */
    public function getCavv()
    {
        return $this->cavv;
    }

    /**
     * @param mixed $cavv
     */
    public function setCavv($cavv): void
    {
        $this->cavv = $cavv;
    }

    /**
     * @return mixed
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @param mixed $eci
     */
    public function setEci($eci): void
    {
        $this->eci = $eci;
    }

    /**
     * @return mixed
     */
    public function getMd()
    {
        return $this->md;
    }

    /**
     * @param mixed $md
     */
    public function setMd($md): void
    {
        $this->md = $md;
    }

    /**
     * @return mixed
     */
    public function getRnd()
    {
        return $this->rnd;
    }

    /**
     * @param mixed $rnd
     */
    public function setRnd($rnd): void
    {
        $this->rnd = $rnd;
    }

    /**
     * @return mixed
     */
    public function getHashParams()
    {
        return $this->hashParams;
    }

    /**
     * @param mixed $hashParams
     */
    public function setHashParams($hashParams): void
    {
        $this->hashParams = $hashParams;
    }

    /**
     * @return mixed
     */
    public function getHashParamsVal()
    {
        return $this->hashParamsVal;
    }

    /**
     * @param mixed $hashParamsVal
     */
    public function setHashParamsVal($hashParamsVal): void
    {
        $this->hashParamsVal = $hashParamsVal;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getTransId()
    {
        return $this->transId;
    }

    /**
     * @param mixed $transId
     */
    public function setTransId($transId): void
    {
        $this->transId = $transId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getInstallment()
    {
        return $this->installment;
    }

    /**
     * @param mixed $installment
     */
    public function setInstallment($installment): void
    {
        $this->installment = $installment;
    }
}
