<?php

namespace App\Controllers;

use App\Services\Financial\FinancialCafef;
use App\Services\Financial\FinancialInterface;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;

class ApiFinancial extends BaseController
{
    /** @var array */
    private $codes;
    /** @var FinancialInterface */
    private $financialService;
    /** @var CacheInterface */
    private $cache;

    public function __construct()
    {
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->financialService = new FinancialCafef();
        $this->cache = Services::cache();
    }

    public function index()
    {
        $results = [];
        foreach ($this->codes as $code) {
            $financialOfCode = $this->cache->get(\App\Commands\RawFinancial::PREFIX . $code);
            if (!empty($financialOfCode)) {
                $results[$code] = unserialize($financialOfCode);
            }
        }
        $this->response($results);
    }
}