<?php

namespace App\Services\Financial;

use App\Models\FinancialModel;
use PHPHtmlParser\Dom;

interface FinancialInterface
{
    /**
     * @param Dom $dom
     * @return FinancialModel[]
     */
    public function parseDomToModel($dom): array;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param array $code
     * @return array
     */
    public function request(array $codes): array;
}