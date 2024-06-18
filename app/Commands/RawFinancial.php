<?php

namespace App\Commands;

use App\Services\Financial\FinancialCafef;
use App\Services\Financial\FinancialInterface;
use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class RawFinancial extends BaseCommand
{
    const PREFIX = 'financial_';

    protected $group       = 'RawFinancial';
    protected $name        = 'rawfinancial';
    protected $description = 'Raw Financial';

    /** @var FinancialInterface */
    private $financialService;
    /** @var array */
    private $codes;
    /** @var CacheInterface */
    private $cache;
    /** @var int */
    private $ttl;

    public function __construct()
    {
        $this->financialService = new FinancialCafef();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->cache = Services::cache();
        $this->ttl = 12 * 60 * 60;
    }

    public function run(array $params)
    {
        $prepareCodes = [];
        foreach ($this->codes as $code) {
            if (!$this->cache->get(self::PREFIX . $code)) {
                $prepareCodes[] = $code;
                if (count($prepareCodes) > 10) {
                    break;
                }
            }
        }
        
        if (!$prepareCodes) {
            CLI::write('Was Done');
        } else {
            $results = $this->financialService->request($prepareCodes);
            foreach ($results as $code => $values) {
                if ($this->cache->save(self::PREFIX . $code, serialize($values), $this->ttl)) {
                    CLI::write($code . ': DONE');
                } else {
                    CLI::write($code . ': FAIL');
                }
            }
        }
        // CLI::write(implode(', ', $params));
    }
}