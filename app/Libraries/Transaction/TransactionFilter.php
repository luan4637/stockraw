<?php

namespace App\Libraries\Transaction;

use App\Models\TransactionModel;
use App\Libraries\Transaction\Filters\FilterInterface;
use Exception;

class TransactionFilter
{
    /** @var FilterInterface[] */
    private $filters;

    /**
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @param string $code
     * @return TransactionModel[]
     */
    public function filter(string $code): array
    {
        $transactions = [];
        foreach ($this->filters as $filter) {
            $transaction = $filter->get($code);
            if ($transaction !== null) {
                $transactions[] = $transaction;
            }
        }
        return $transactions;
    }

    /**
     * @param string $code
     * @return int
     */
    public function getTotalVol(string $code): int
    {
        $transactions = $this->filter($code);
        $totalVol = 0;
        foreach ($transactions as $transaction) {
            $totalVol += $transaction->vol;
        }

        return $totalVol;
    }

    /**
     * @param string $code
     * @return float
     */
    public function getCur(string $code): float
    {
        if (!$this->filters) {
            throw new Exception('No filter');
        }

        $transaction = $this->filters[0]->get($code);

        if ($transaction) {
            return $transaction->cur;
        }
        
        return 0;
    }

    /**
     * @param string $code
     * @return float
     */
    public function getCurAverage(string $code): float
    {
        $transactions = $this->filter($code);

        $min = PHP_INT_MAX;
        foreach ($transactions as $transaction) {
            if ($transaction->cur < $min) {
                $min = $transaction->cur;
            }
        }

        $max = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->cur > $max) {
                $max = $transaction->cur;
            }
        }

        if ($max == 0) {
            return -1;
        }

        return number_format(($max - $min) / $max * 100, 2, '.', '');
    }
}