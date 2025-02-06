<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Factoryes;

use Omnipay\NestPay\ThreeDResponse;

class ThreeDResponseFactory
{
    public static function getThreeDResponse(array $responseData): ThreeDResponse
    {
        $threeDResponse = new ThreeDResponse();

        $ipAddress = $responseData['clientIp'] ?? null;
        $installment = $responseData['taksit'] ?? null;
        $userId = $responseData['userId'] ?? null;
        $groupId = $responseData['groupId'] ?? null;
        $transId = $responseData['TRANID'] ?? null;
        $threeDResponse->setMdStatus($responseData['mdStatus']);
        $threeDResponse->setClientId($responseData['clientid']);
        $threeDResponse->setAmount($responseData['amount']);
        $threeDResponse->setCurrency($responseData['currency']);
        $threeDResponse->setXid($responseData['xid']);
        $threeDResponse->setOid($responseData['oid']);
        $threeDResponse->setCavv($responseData['cavv'] ?? null);
        $threeDResponse->setEci($responseData['eci'] ?? null);
        $threeDResponse->setMd($responseData['md']);
        $threeDResponse->setRnd($responseData['rnd']);
        $threeDResponse->setHashParams($responseData['HASHPARAMS'] ?? null);
        $threeDResponse->setHashParamsVal(
            $responseData['HASHPARAMSVAL'] ?? null
        );
        $threeDResponse->setHash($responseData['HASH']);

        if ($ipAddress !== null) {
            $threeDResponse->setIpAddress($ipAddress);
        }

        $threeDResponse->setInstallment($installment);
        $threeDResponse->setUserId($userId);
        $threeDResponse->setGroupId($groupId);
        $threeDResponse->setTransId($transId);

        return $threeDResponse;
    }
}
