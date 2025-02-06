<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return 'Purchase3D';
    }

    /**
     * @return string
     */
    public function getProcessType(): string
    {
        return 'Auth';
    }

    public function getPurchase3DHostingData(): array
    {
        $redirectUrl = $this->getEndpoint();

        $data = [];
        $data['clientid'] = $this->getClientId();
        $data['oid'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrencyNumeric();
        $data['lang'] = $this->getLang();
        $data['okUrl'] = $this->getReturnUrl();
        $data['failUrl'] = $this->getCancelUrl();
        $data['storetype'] = '3d_pay_hosting';
        $data['trantype'] = 'Auth';
        $data['rnd'] = $this->getRnd();
        $data['refreshtime'] = $this->getTestMode() ? 10 : 0;
        $installment = $this->getInstallment();

        if ($installment !== null && $installment > 1) {
            $data['taksit'] = $installment;
        }

        $data['hashAlgorithm'] = 'ver3';

        $data['redirectUrl'] = $redirectUrl;
        ksort($data);
        $hashString = '';

        foreach ($data as $value) {
            $escapedValue = str_replace(['|', '\\'], ['\|', '\\\\'], (string)$value);
            $hashString .= $escapedValue.'|';
        }

        $hashString .= $this->getStoreKey();
        $data['hash'] = base64_encode(hash('sha512', $hashString, true));

        return $data;
    }


    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount');
        $this->setAction('3d');

        return $this->getPurchase3DHostingData();
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    public function sendData($data): ResponseInterface
    {
        return $this->response = $this->createResponse($data);
    }

    /**
     * @param $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     * @throws \JsonException
     */
    protected function createResponse($data): ResponseInterface
    {
        return new PurchaseResponse($this, $data);
    }
}
