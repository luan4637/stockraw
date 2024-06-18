<?php

namespace App\Libraries\StockData;

interface FilterInterface
{
    /**
     * @return array
     */
    public function getFilters(): array;
}