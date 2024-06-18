<?php

namespace App\Libraries\StockData\Condition;

class ConditionGreaterEqual extends AbstractCondition implements ConditionInterface
{
    const CONDITION = '>=';

    /**
     * @return string
     */
    protected function getValue(): string
    {
        return self::CONDITION;
    }
}