<?php

namespace App\Commands;

use App\Repository\TransactionRepository;
use App\Services\HistoryTransaction\HistoryTransactionFireant;
use App\Services\HistoryTransaction\HistoryTransactionCafef;
use App\Services\HistoryTransaction\HistoryTransactionStockbiz;
use CodeIgniter\CLI\CLI;
use Config\Services;

class RawTransaction extends BaseCmd
{
    const CANCEL_STOCKS = 'cancelStocks';
    const CACHE_TTL = 7 * 24 * 60 * 60;
    protected $group       = 'RawTransaction';
    protected $name        = 'rawtrans';
    protected $description = 'Raw Transaction';

    private $transactionRepository;
    private $historyTransaction;
    private $codes;
    private $cache;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
        $this->historyTransaction = new HistoryTransactionFireant();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->cache = Services::cache();
    }

    public function run(array $params)
    {
        while (true) {
            $failCodesCache = $this->cache->get(self::CANCEL_STOCKS) ?? false;
            $failCodesCache = $failCodesCache ? \unserialize($failCodesCache) : [];
            $prepareCodes = [];
            foreach ($this->codes as $code) {
                if (!$this->transactionRepository->isExited($code) 
                    && !in_array($code, $failCodesCache))
                {
                    $prepareCodes[] = $code;
                }
                if (count($prepareCodes) > 10) {
                    break;
                }
            }
            
            if (!$prepareCodes) {
                CLI::write('DONE ALL');
                break;
            } else {
                try {
                    $resultCodes = $this->historyTransaction->request($prepareCodes);
                    $failCodes = $resultCodes['failCodes'];

                    CLI::write('DONE: ' . implode(' ', $resultCodes['successCodes']));
                    if ($failCodes) {
                        CLI::write('EMPTY: ' . implode(' ', $failCodes));
                    }

                    $failCodes = array_merge($failCodesCache, $failCodes);
                    $this->cache->save(self::CANCEL_STOCKS, \serialize($failCodes), self::CACHE_TTL);
                } catch (\Exception $e) {
                    CLI::write('FAIL REQUEST: ' . date('Y-m-d H:i:s'));
                }
            }
            sleep(3);
        }
    }
}