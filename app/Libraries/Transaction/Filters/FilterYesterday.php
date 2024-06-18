<?php

namespace App\Libraries\Transaction\Filters;

use App\Models\TransactionModel;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;

class FilterYesterday implements FilterInterface
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
            if ($transaction->date == getYesterday()) {
                $result = $transaction;
                break;
            }
        }
        
        return $result;
    }
}

if (!function_exists('getWeekday')) {
    function getWeekday(int $numDay = 0, string $format = 'Y-m-d')
    {
        $day = date('l');
        if ($day == 'Saturday' || $day == 'Sunday') {
            $numDay -= 1;
        }

        $weekday = date($format, strtotime($numDay . ' weekday'));

        return $weekday;
    }
}

if (!function_exists('getYesterday')) {
    function getYesterday()
    {
        return getWeekday(-1);
    }
}