<?php

namespace App\Libraries\StockData\Param;

interface ParamInterface
{
    /**
     * @return string
     */
    public function getConditionClause(): string;

    /**
     * @return int|string
     */
    public function getValue();
}