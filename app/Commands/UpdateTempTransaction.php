<?php

namespace App\Commands;

use App\Repository\TransactionRepository;
use App\Repository\TransactionTmpRepository;
use CodeIgniter\CLI\CLI;
use Config\Services;

class UpdateTempTransaction extends BaseCmd
{
    protected $group       = 'UpdateTempTransaction';
    protected $name        = 'tmptrans';
    protected $description = 'Update TempTransaction';

    private $transactionRepository;
    private $transactionTmpRepository;
    private $codes;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
        $this->transactionTmpRepository = new TransactionTmpRepository();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));

        parent::__construct();
    }

    public function run(array $params)
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
    }
}