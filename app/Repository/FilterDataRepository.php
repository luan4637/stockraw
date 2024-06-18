<?php

namespace App\Repository;

class FilterDataRepository
{
    /** @var \CodeIgniter\Database\BaseBuilder */
    private $builder;
    /** @var App\Models\TransactionModel */
    private $transactionModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('transaction AS t');
        $this->transactionModel = model('App\Models\TransactionModel');
    }

    /**
     * @return array
     */
    public function transactionFor6days(): array
    {
        $pre6days = [];
        for ($i = -5; $i <=0; $i++) {
            $pre6days[] = \getWeekday($i);
        }

        $this->builder->select("t.code, CONCAT('{', GROUP_CONCAT(CONCAT('\"', t.date, '\":\"', t.cur, '\"') SEPARATOR  ','), '}') AS curs");
        $this->builder->whereIn('t.date', $pre6days);
        $this->builder->groupBy('t.code');

        // echo $this->builder->getCompiledSelect(); die;

        return $this->builder->get()->getResultArray();
    }
}