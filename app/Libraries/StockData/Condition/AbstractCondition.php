<?php

namespace App\Libraries\StockData\Condition;

abstract class AbstractCondition
{
    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->getValue();
    }

    abstract protected function getValue();
}