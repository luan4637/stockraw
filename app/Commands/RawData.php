<?php

namespace App\Commands;

use App\Repository\TransactionRepository;
use App\Repository\TransactionTmpRepository;
use App\Services\Exchange\ExchangeVps;
use CodeIgniter\CLI\CLI;
use Config\Services;

class RawData extends BaseCmd
{
    protected $group       = 'RawData';
    protected $name        = 'rawdata';
    protected $description = 'Raw Data';

    /** @var ExchangeVps */
    private $exchangeService;
    /** @var array */
    private $codes;
    /** @var \CodeIgniter\Cache\CacheInterface */
    private $cache;
    /** @var TransactionRepository */
    private $transactionRepository;
    /** @var TransactionTmpRepository */
    private $transactionTmpRepository;

    public function __construct()
    {
        $this->exchangeService = new ExchangeVps();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->cache = Services::cache();
        $this->transactionRepository = new TransactionRepository();
        $this->transactionTmpRepository = new TransactionTmpRepository();

        parent::__construct();
    }

    public function run(array $params)
    {
        $failCodesCache = $this->cache->get(RawTransaction::CANCEL_STOCKS) ?? false;
        $failCodesCache = $failCodesCache ? \unserialize($failCodesCache) : [];
        $this->codes = array_diff($this->codes, $failCodesCache);
        $this->updateTempTransaction();
        
        // $this->exchangeService->request($this->codes);

        while (true) {
            if ($this->canRaw()) {
                try {
                    $this->exchangeService->request($this->codes);

                    CLI::write('DONE: ' . date('Y-m-d H:i:s'));
                } catch (\Exception $e) {
                    CLI::write('FAIL REQUEST: ' . date('Y-m-d H:i:s'));
                }
            } else {
                CLI::write('DO NOTHING');
                if ($this->sessionEnd()) {
                    CLI::write('SESSION END');
                    break;
                }
            }
            sleep(20);
        }
    }

    private function canRaw() {
        $curHour = date('H');
        $curMin = date('i');

        // return true;

        return $curHour == 9 && $curMin > 15
                || $curHour == 10
                || $curHour == 11 && $curMin <= 30
                || $curHour == 13
                || $curHour == 14 && $curMin <= 30;
    }

    private function sessionEnd() {
        $curHour = date('H');
        $curMin = date('i');

        return $curHour == 14 && $curMin > 35 || $curHour >= 15;
    }

    private function updateTempTransaction()
    {
        $this->transactionTmpRepository->deleteAll();

        foreach ($this->codes as $code) {
            $transactions = $this->transactionRepository->getLastestThreeDays($code);
            $yesterday = 0;
            $twoDayAgo = 0;
            $threeDayAgo = 0;
            foreach ($transactions as $transaction) {
                if ($yesterday === 0) {
                    $yesterday = $transaction['date'] == \getWeekday(-1) ? $transaction['vol'] : 0;
                }
                if ($twoDayAgo === 0) {
                    $twoDayAgo = $transaction['date'] == \getWeekday(-2) ? $transaction['vol'] : 0;
                }
                if ($threeDayAgo === 0) {
                    $threeDayAgo = $transaction['date'] == \getWeekday(-3) ? $transaction['vol'] : 0;
                }
            }

            $this->transactionTmpRepository->save([
                'code' => $code,
                'yesterday' => $yesterday,
                'twoDayAgo' => $twoDayAgo,
                'threeDayAgo' => $threeDayAgo
            ]);
        }
        CLI::write('DONE UPDATE TEMP TRANSACTION');
        CLI::write('----------------------------');
    }
}