<?php

namespace App\Services\Exchange;

interface AbstractRequestInterface
{
    /**
     * @param array $codes
     * @return StockModel[]
     */
    public function request(array $codes);
}