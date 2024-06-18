<?php

namespace App\Services\Exchange;

interface ExchangeInterface extends AbstractRequestInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;
}