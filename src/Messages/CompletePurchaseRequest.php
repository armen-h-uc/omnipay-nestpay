<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\NestPay\Factoryes\ThreeDResponseFactory;
use Omnipay\NestPay\ThreeDResponse;
use RuntimeException;

class CompletePurchaseRequest extends AbstractRequest
{
    private const PAYMENT_TYPE_3D_HOSTING = "3d_pay_hosting";

    /** @var ThreeDResponse */
    private ThreeDResponse $threeDResponse;

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
     * @param ThreeDResponse $threeDResponse
     * @return array
     */
    protected function getCompletePurchaseParams(ThreeDResponse $threeDResponse): array
    {
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $threeDResponse->getClientId();
        $data['IPAddress'] = $threeDResponse->getIpAddress();
        $data['Mode'] = ($this->getTestMode()) ? 'T' : 'P';
        $data['Number'] = $threeDResponse->getMd();
        $data['OrderId'] = $threeDResponse->getOid();
        $data['GroupId'] = $threeDResponse->getGroupId() ?? '';
        $data['TransId'] = $threeDResponse->getTransId() ?? '';
        $data['UserId'] = $threeDResponse->getUserId() ?? '';
        $data['Type'] = $this->getProcessType();
        $data['Expires'] = '';
        $data['Cvv2Val'] = '';
        $data['Total'] = $threeDResponse->getAmount();
        $data['Currency'] = $threeDResponse->getCurrency();
        $installment = $threeDResponse->getInstallment();

        if (empty($installment) || (int)$installment < 2) {
            $installment = '';
        }

        $data['Taksit'] = $installment;
        $data['PayerTxnId'] = $threeDResponse->getXid();
        $data['PayerSecurityLevel'] = $threeDResponse->getEci();
        $data['PayerAuthenticationCode'] = $threeDResponse->getCavv();
        $data['CardholderPresentCode'] = 13;
        $data['bill'] = $this->getBillTo();
        $data['ship'] = $this->getShipTo();
        $data['Extra'] = '';

        return $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $paymentType = $this->getResponseData()['storetype'] ?? null;

        $this->threeDResponse = $this->getThreeDResponse();

        if ($paymentType !== self::PAYMENT_TYPE_3D_HOSTING) {
            if (!in_array($this->threeDResponse->getMdStatus(), [1, 2, 3, 4], false)) {
                throw new RuntimeException('3DSecure verification error');
            }
        }

        if (!$this->checkHash()) {
            throw new RuntimeException('Hash data invalid');
        }

        return $this->getCompletePurchaseParams($this->threeDResponse);
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    public function sendData($data): ResponseInterface
    {
        return $this->response = $this->createResponse($this->getResponseData());
    }

    /**
     * @param $data
     *
     * @return CompletePurchaseResponse
     * @throws \JsonException
     */
    protected function createResponse($data): CompletePurchaseResponse
    {
        return new CompletePurchaseResponse($this, $data);
    }

    /**
     * @return \Omnipay\NestPay\ThreeDResponse
     */
    private function getThreeDResponse(): ThreeDResponse
    {
        $responseData = $this->getResponseData();

        return ThreeDResponseFactory::getThreeDResponse($responseData);
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
