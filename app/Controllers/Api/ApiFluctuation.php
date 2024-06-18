<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repository\TransactionRepository;

class ApiFluctuation extends BaseController
{
    /** @var TransactionRepository */
    private $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }

    public function index()
    {
        /** @var int $numDays */
        $numDays = $this->request->getVar('day') ?? 5;
        /** @var int $vol */
        $vol = $this->request->getVar('vol') ?? 10000;
        /** @var array $results */
        $results = $this->transactionRepository->getTransactionsDay($vol, $numDays);
        
        foreach ($results as &$item) {
            $item['avg'] = number_format(($item['max'] - $item['min']) / $item['max'] * 100, 2);
        }

        usort($results, function ($item1, $item2) {
            return $item1['avg'] <=> $item2['avg'];
        });

        $this->response([
            'total' => count($results),
            'data' => $results,
        ]);
    }
}
