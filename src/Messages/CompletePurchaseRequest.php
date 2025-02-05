<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\NestPay\ThreeDResponse;
use RuntimeException;

class CompletePurchaseRequest extends AbstractRequest
{
    private const PAYMENT_TYPE_3D_HOSTING = "3d_pay_hosting";

    /** @var ThreeDResponse */
    private ThreeDResponse $threeDResponse;
    private string|null $paymentType;

    /**
     * @return string[]
     */
    public function getSensitiveData(): array
    {
        return ['Password', 'Number', 'Expires', 'Cvv2Val'];
    }

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'CompletePurchase';
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
     */
    public function getData(): array
    {
        $this->paymentType = $this->getResponseData()['storetype'] ?? null;

        $this->threeDResponse = $this->getThreeDResponse();

        if ($this->paymentType !== self::PAYMENT_TYPE_3D_HOSTING) {
            if (!in_array($this->threeDResponse->getMdStatus(), [1, 2, 3, 4], false)) {
                throw new RuntimeException('3DSecure verification error');
            }
        }

        if (!$this->checkHash()) {
            throw new RuntimeException('Hash data invalid');
        }

        $data = $this->getCompletePurchaseParams($this->threeDResponse);
        $this->setRequestParams($data);

        return $data;
    }


    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data): ResponseInterface
    {
        if ($this->paymentType == self::PAYMENT_TYPE_3D_HOSTING) {
            return $this->response = $this->createResponse($this->getResponseData());
        }

        return parent::sendData($data);
    }

    /**
     * @param $data
     *
     * @return CompletePurchaseResponse
     * @throws \JsonException
     */
    protected function createResponse($data): CompletePurchaseResponse
    {
        $response = new CompletePurchaseResponse($this, $data);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    /**
     * @return \Omnipay\NestPay\ThreeDResponse
     */
    private function getThreeDResponse(): ThreeDResponse
    {
        $threeDResponse = new ThreeDResponse();
        $responseData = $this->getResponseData();
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

    /**
     * @return bool
     */
    private function checkHash(): bool
    {
        $responseHash = $this->threeDResponse->getHash();
        $generatedHash = $this->getGeneratedHash();

        return ($responseHash === $generatedHash);
    }

    /**
     * @return string
     */
    private function getGeneratedHash(): string
    {
        $data = $this->getResponseData();
        $postParams = [];

        foreach ($data as $key => $value) {
            $postParams[] = $key;
        }

        natcasesort($postParams);

        $hashVal = "";

        foreach ($postParams as $param) {
            $paramValue = $data[$param];
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);

            if ($lowerParam != "hash" && $lowerParam != "encoding") {
                $hashVal = $hashVal.$escapedParamValue."|";
            }
        }

        $storeKey = $this->getStoreKey();
        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
        $hashVal = $hashVal.$escapedStoreKey;
        $calculatedHashValue = hash('sha512', $hashVal);

        return base64_encode(pack('H*', $calculatedHashValue));
    }
}
