<?php

namespace App\Libraries\Transaction\Filters;

use App\Models\TransactionModel;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;

class FilterToday implements FilterInterface
{
    /** @var CacheInterface $cache */
    private $cache;

    public function __construct()
    {
        $this->cache = Services::cache();
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
            if ($transaction->date == getToday()) {
                $result = $transaction;
                break;
            }
        }
        
        return $result;
    }
}