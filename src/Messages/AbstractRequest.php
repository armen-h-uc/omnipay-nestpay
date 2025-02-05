<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Messages;

use DOMDocument;
use DOMElement;
use Exception;
use InvalidArgumentException;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\NestPay\Mask;
use Omnipay\NestPay\RequestInterface;
use Omnipay\NestPay\ThreeDResponse;
use Omnipay\NestPay\Traits\ParametersTrait;
use Omnipay\NestPay\Traits\RequestTrait;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest implements RequestInterface
{
    use RequestTrait;
    use ParametersTrait;

    /** @var $root DOMElement */
    private DOMElement $root;

    /** @var DOMDocument */
    private DOMDocument $document;

    private string $action = "purchase";

    /** @var array */
    protected array $requestParams;

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setClientId(string $value): AbstractRequest
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAction(string $value): void
    {
        $this->action = $value;
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
     * @return AbstractRequest
     */
    public function setUserName(string $value): AbstractRequest
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
     * @return AbstractRequest
     */
    public function setPassword(string $value): AbstractRequest
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|AbstractResponse
     * @throws InvalidResponseException
     */
    public function sendData($data): AbstractResponse|ResponseInterface
    {
        try {
            $processType = $this->getProcessType();
            if (!empty($processType)) {
                $data['Type'] = $processType;
            }
            $shipInfo = $data['ship'] ?? [];
            $billInfo = $data['bill'] ?? [];
            unset($data['ship'], $data['bill']);

            $this->document = new DOMDocument('1.0', 'UTF-8');
            $this->root = $this->document->createElement('CC5Request');
            foreach ($data as $id => $value) {
                $this->root->appendChild($this->document->createElement($id, (string)$value));
            }

            $extra = $this->document->createElement('Extra');

            if (!empty($this->getStatus())) {
                $extra->appendChild($this->document->createElement('ORDERSTATUS', 'QUERY'));
                $this->root->appendChild($extra);
            }

            $this->document->appendChild($this->root);
            $this->addShipAndBillToXml($shipInfo, $billInfo);
            $httpRequest = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                ['Content-Type' => 'application/x-www-form-urlencoded'],
                $this->document->saveXML()
            );

            $response = (string)$httpRequest->getBody()->getContents();

            return $this->response = $this->createResponse($response);
        } catch (Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @return string|null
     */
    public function getInstallment(): ?string
    {
        return $this->getParameter('installment');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setInstallment(string $value): AbstractRequest
    {
        return $this->setParameter('installment', $value);
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
     * @return AbstractRequest
     */
    public function setBank(string $value): AbstractRequest
    {
        return $this->setParameter('bank', $value);
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->getParameter('status');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setStatus(string $value): AbstractRequest
    {
        return $this->setParameter('status', $value);
    }

    /**
     * @return string
     */
    protected function getHttpMethod(): string
    {
        return 'POST';
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
     * @return string|null
     */
    public function getCurrencyNumeric(): ?string
    {
        $number = parent::getCurrencyNumeric();
        if (!is_null($number)) {
            return str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        return null;
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getPurchase3DHostingData(): array
    {
        $redirectUrl = $this->getEndpoint();
        $this->validate('amount');

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
            $escapedValue = str_replace(['|', '\\'], ['\|', '\\\\'], (string) $value);
            $hashString .= $escapedValue . '|';
        }

        $hashString .= $this->getStoreKey();
        $data['hash'] = base64_encode(hash('sha512', $hashString, true));

        return $data;
    }

    /**
     * @return array
     */
    protected function getRequestParams(): array
    {
        return [
            'url' => $this->getEndPoint(),
            'type' => $this->getProcessType(),
            'data' => $this->requestParams,
            'method' => $this->getHttpMethod()
        ];
    }

    /**
     * @param array $data
     *
     * @return void
     */
    protected function setRequestParams(array $data): void
    {
        array_walk_recursive($data, [$this, 'updateValue']);
        $this->requestParams = $data;
    }

    /**
     * @param $data
     * @param $key
     *
     * @return void
     */
    protected function updateValue(&$data, $key): void
    {
        $sensitiveData = $this->getSensitiveData();

        if (\in_array($key, $sensitiveData, true)) {
            $data = Mask::mask($data);
        }
    }

    /**
     * @param array $ship
     * @param array $bill
     *
     * @return void
     * @throws \DOMException
     */
    private function addShipAndBillToXml(array $ship, array $bill): void
    {
        if (count($ship) > 0 && count($bill) > 0) {
            $shipTo = $this->document->createElement('ShipTo');
            foreach ($ship as $id => $value) {
                $shipTo->appendChild($this->document->createElement($id, $value));
            }

            $this->root->appendChild($shipTo);

            $billTo = $this->document->createElement('BillTo');
            foreach ($bill as $id => $value) {
                $billTo->appendChild($this->document->createElement($id, $value));
            }

            $this->root->appendChild($billTo);
        }
    }

    /**
     * @return string[]
     */
    private function getBillTo(): array
    {
        return [
            'Name' => '',
            'Street1' => '',
            'Street2' => '',
            'Street3' => '',
            'City' => '',
            'StateProv' => '',
            'PostalCode' => '',
            'Country' => '',
            'Company' => '',
            'TelVoice' => '',
        ];
    }

    /**
     * @return string[]
     */
    private function getShipTo(): array
    {
        return [
            'Name' => '',
            'Street1' => '',
            'Street2' => '',
            'Street3' => '',
            'City' => '',
            'StateProv' => '',
            'PostalCode' => '',
            'Country' => ''
        ];
    }
}
