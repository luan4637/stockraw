<?php

namespace App\Repository\Cache;

use App\Libraries\StockData\FilterInterface;
use App\Libraries\StockData\SortOrderInterface;

interface StockDataRepositoryInterface
{
    /**
     * @param FilterInterface $filter
     * @param SortOrderInterface $sortOrder
     * @return array
     */
    public function getLastestStockData(FilterInterface $filter, SortOrderInterface $sortOrder): array;

    /**
     * @param FilterInterface $filter
     * @param SortOrderInterface $sortOrder
     * @return array
     */
    public function getLastestStockDataNoCache(FilterInterface $filter, SortOrderInterface $sortOrder): array;

    /**
     * @return array
     */
    public function getDates(): array;

    /**
     * @param string $date
     * @return array
     */
    public function getTimes(string $date): array;
}