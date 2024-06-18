<?php

namespace App\Services\HistoryTransaction;

use App\Models\TransactionModel;
use voku\helper\HtmlDomParser;

interface HistoryTransactionInterface
{
    /**
     * @param HtmlDomParser $dom
     * @return TransactionModel[]
     */
    public function parseDomToModel(HtmlDomParser $dom): array;

    /**
     * @return string
     */
    public function getUrl(): string;
}