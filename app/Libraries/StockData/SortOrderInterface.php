<?php

namespace App\Libraries\StockData;

interface SortOrderInterface
{
    /**
     * @return string
     */
    public function getSort(): string;

    /**
     * @return string
     */
    public function getOrder(): string;
}