<?php

declare(strict_types=1);

namespace Omnipay\NestPay;

interface RequestInterface
{
    /**
     * @return string
     */
    public function getProcessName(): string;

    /**
     * @return string
     */
    public function getProcessType(): string;
}
