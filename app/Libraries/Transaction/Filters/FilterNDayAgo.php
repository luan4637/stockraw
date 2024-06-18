<?php

namespace App\Libraries\Transaction\Filters;

use App\Models\TransactionModel;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;

class FilterNDayAgo implements FilterInterface
{
    /** @var CacheInterface $cache */
    private $cache;
    /** @var int $numDays */
    private $numDays;

    /**
     * @param int $numDays
     */
    public function __construct(int $numDays)
    {
        $this->cache = Services::cache();
        $this->numDays = $numDays;
    }

    /**
     * @inheritdoc
     */
    public function get(string $code)
    {
        $result = null;
        /** @var TransactionModel[]|bool $transactions */
        $transactions = unserialize($this->cache->get($code));
        if (!$transactions) {
            return null;
        }

        foreach ($transactions as $transaction) {
            if ($transaction->date == getWeekday(-$this->numDays)) {
                $result = $transaction;
                break;
            }
        }
        
        return $result;
    }
}