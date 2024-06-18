<?php

namespace App\Repository\Cache;

use App\Libraries\StockData\FilterInterface;
use App\Libraries\StockData\SortOrderInterface;
use App\Repository\StockDataRepository;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;

class StockDataRepositoryCache implements StockDataRepositoryInterface
{
    const LASTEST_STOCKS = 'getLastestStockData';
    const CACHE_TTL = 5;

    /** @var StockDataRepository */
    private $stockDataRepository;
    /** @var CacheInterface */
    private $cache;

    public function __construct()
    {
        $this->stockDataRepository = new StockDataRepository();
        $this->cache = Services::cache();
    }

    /**
     * @inheritdoc
     */
    public function getLastestStockData(FilterInterface $filter, SortOrderInterface $sortOrder): array
    {
        /*
        $lastestStocks = $this->cache->get(self::LASTEST_STOCKS);
        // $lastestStocks = '';
        if ($lastestStocks) {
            return \unserialize($lastestStocks);
        } else {
            $lastestStocks = $this->stockDataRepository->getLastestStockData($filter, $sortOrder);
            $this->cache->save(self::LASTEST_STOCKS, \serialize($lastestStocks), self::CACHE_TTL);
        }*/
        $lastestStocks = $this->stockDataRepository->getLastestStockData($filter, $sortOrder);
        return $lastestStocks;
    }

    /**
     * @inheritdoc
     */
    public function getLastestStockDataNoCache(FilterInterface $filter, SortOrderInterface $sortOrder): array
    {
        return $this->stockDataRepository->getLastestStockData($filter, $sortOrder);
    }

    /**
     * @inheritdoc
     */
    public function getDates(): array
    {
        return $this->stockDataRepository->getDates();
    }

    /**
     * @inheritdoc
     */
    public function getTimes(string $date): array
    {
        return $this->stockDataRepository->getTimes($date);
    }
}