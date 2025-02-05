<?php

declare(strict_types=1);

namespace Omnipay\NestPay\Traits;

trait RequestTrait
{
    public array $baseUrls = [
        'bktbank' => 'https://pgw.bkt.com.al',
        'test' => 'https://torus-stage-bkt.asseco-see.com.tr'
    ];

    protected array $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public array $url = [
        'test' => [
            'purchase' => '/fim/api',
            '3d' => '/fim/est3Dgate'
        ],
        "3d" => "/servlet/est3Dgate",
        "3dhsbc" => "/servlet/hsbc3Dgate",
        "list" => "/servlet/listapproved",
        "detail" => "/servlet/cc5ApiServer",
        "cancel" => "/servlet/cc5ApiServer",
        "return" => "/servlet/cc5ApiServer",
        "purchase" => "/servlet/cc5ApiServer"
    ];

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        $baseUrl = $this->getBaseUrl();
        $action = $this->getAction();
        if ($this->getTestMode()) {
            return $baseUrl . $this->url['test'][$action];
        }

        return $baseUrl . $this->url[$action];
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        $bank = $this->getBank();
        if ($this->getTestMode()) {
            return $this->baseUrls['test'];
        }
        return $this->baseUrls[$bank];
    }

    /**
     * @return string
     */
    public function getRnd(): string
    {
        return (string) time();
    }
}
