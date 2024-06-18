<?php

namespace App\Libraries\StockData\Condition;

interface ConditionInterface
{
    /**
     * @return string
     */
    public function getCondition(): string;
}