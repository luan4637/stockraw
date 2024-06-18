<?php

namespace App\Libraries\Transaction;

use App\Libraries\Transaction\Filters\FilterNDayAgo;

class TransactionFilterDaysAgo extends TransactionFilter
{
    /**
     * @param int $totalDaysAgo
     */
    public function __construct(int $totalDaysAgo)
    {
        for ($i = 0; $i <= $totalDaysAgo; $i++) {
            $filters[] = new FilterNDayAgo($i);
        }

        parent::__construct($filters);
    }
}