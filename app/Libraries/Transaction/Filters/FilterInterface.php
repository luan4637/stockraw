<?php

namespace App\Libraries\Transaction\Filters;

use App\Models\TransactionModel;

interface FilterInterface
{
    /**
     * @param string $code
     * @return TransactionModel|null
     */
    public function get(string $code);
}