<?php

namespace App\Libraries\Stock\StockFilter\Condition;

interface ConditionInterface
{
    /**
     * @param StockModel[] $stocks
     * @param string $keyParam
     * @return StockModel[]
     */
    public function filterResults(array $stocks, string $keyParam);
}