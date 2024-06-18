<?php

namespace App\Repository;

use App\Models\TransactionModel;

class TransactionRepository
{
    /** @var \CodeIgniter\Database\BaseBuilder */
    private $builder;
    /** @var TransactionModel */
    private $transactionModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('transaction AS t');
        $this->transactionModel = model('App\Models\TransactionModel');
    }

    /**
     * @param array $transaction
     * @return bool
     */
    public function save(array $transaction): bool
    {
        return $this->transactionModel->insert($transaction, false);
    }

    /**
     * @param string $code
     * @return TransactionModel[]
     */
    public function getTransactionsByCode(string $code, int $days = -20): array
    {
        /** @var TransactionModel[] $transactions */
        $transactions = $this->transactionModel
                            ->where('code', $code)
                            ->where('date >=', \getWeekday(++$days))
                            ->orderBy('date', 'desc')
                            ->findAll();

        return $transactions;
    }

    /**
     * @param string $code
     * @return TransactionModel[]
     */
    public function getLastestThreeDays(string $code): array
    {
        return $this->getTransactionsByCode($code, -3);
    }

    /**
     * @param string $code
     * @return bool
     */
    public function isExited(string $code): bool
    {
        $transactionDay = \getWeekday();
        if (\isWorkingHour()) {
            $transactionDay = \getWeekday(-1);
        }
        /** @var \App\Models\TransactionModel $transaction */
        $transaction = $this->transactionModel->where('code', $code)->where('date', $transactionDay)->first();
        if ($transaction) {
            return true;
        }
        
        return false;
    }

    /**
     * @param int $vol
     * @param int $days
     * @return array
     */
    public function getTransactionsDay(int $vol, int $days): array
    {
        $daysAgo = \getWeekday(-$days);

        $this->builder->select('t.code, MAX(t.cur) AS max, MIN(t.cur) AS min, tmp.yesterday, tmp.twoDayAgo, tmp.threeDayAgo, c.des');
        $this->builder->join(\App\Models\TransactionTmpModel::TABLE_NAME . ' AS tmp', 't.code = tmp.code');
        $this->builder->join(\App\Models\CodeModel::TABLE_NAME . ' AS c', 'c.name = t.code');
        $this->builder->where('t.date >=', $daysAgo);
        $this->builder->where('tmp.yesterday >=', $vol);
        $this->builder->groupBy('t.code');

        return $this->builder->get()->getResultArray();
    }
}