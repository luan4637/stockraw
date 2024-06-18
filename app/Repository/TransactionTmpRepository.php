<?php

namespace App\Repository;

class TransactionTmpRepository
{
    /** @var App\Models\TransactionTmpModel */
    private $transactionTmpModel;

    public function __construct()
    {
        $this->transactionTmpModel = model('App\Models\TransactionTmpModel');
    }

    /**
     * @param array $transaction
     * @return bool
     */
    public function save(array $transaction): bool
    {
        return $this->transactionTmpModel->insert($transaction, false);
    }

    public function deleteAll(): bool
    {
        return $this->transactionTmpModel->where('id > ', 0)->delete();
    }
}