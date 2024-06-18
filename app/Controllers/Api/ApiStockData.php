<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repository\Cache\StockDataRepositoryCache;
use App\Repository\Cache\StockDataRepositoryInterface;
use App\Repository\TransactionRepository;

class ApiStockData extends BaseController
{
    /** @var StockDataRepositoryInterface */
    private $stockDataRepository;
    /** @var TransactionRepository */
    private $transactionRepository;

    public function __construct()
    {
        $this->stockDataRepository = new StockDataRepositoryCache();
        $this->transactionRepository = new TransactionRepository();
    }

    public function index()
    {
        /** @var array $stockDatas */
        $stockDatas = $this->stockDataRepository->getLastestStockData(
            new \App\Libraries\StockData\Filter([
                new \App\Libraries\StockData\Param\ParamPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamVol($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamVolPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamGroupId($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamDate($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamTime($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
            ]),
            new \App\Libraries\StockData\SortOrder($this->request)
        );

        $this->response([
            'total' => count($stockDatas),
            'data' => $stockDatas,
        ]);
    }

    public function sell()
    {
        /** @var array $stockDatas */
        $stockDatas = $this->stockDataRepository->getLastestStockDataNoCache(
            new \App\Libraries\StockData\Filter([
                new \App\Libraries\StockData\Param\ParamPercent($this->request, new \App\Libraries\StockData\Condition\ConditionLessEqual()),
                new \App\Libraries\StockData\Param\ParamVol($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamVolPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamGroupId($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamDate($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamTime($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
            ]),
            new \App\Libraries\StockData\SortOrder($this->request)
        );

        $this->response([
            'total' => count($stockDatas),
            'data' => $stockDatas,
        ]);
    }

    public function history()
    {
        /** @var array $stockDatas */
        $stockDatas = $this->stockDataRepository->getLastestStockData(
            new \App\Libraries\StockData\Filter([
                new \App\Libraries\StockData\Param\ParamPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamVol($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamVolPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
                new \App\Libraries\StockData\Param\ParamGroupId($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamDate($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
                new \App\Libraries\StockData\Param\ParamTime($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
            ]),
            new \App\Libraries\StockData\SortOrder($this->request)
        );

        /** @var int $prediction */
        $prediction = (int) $this->request->getVar('prediction') ?? 3;

        foreach ($stockDatas as &$item) {
            $item['transactions'] = $this->transactionRepository->getTransactionsByCode($item['code'], -$prediction);
        }

        $this->response([
            'total' => count($stockDatas),
            'data' => $stockDatas,
        ]);
    }

    public function datesAndTimesSelect()
    {
        /** @var string $paramDate */
        $paramDate = $this->request->getVar('date');
        /** @var array $dates */
        $dates = $this->stockDataRepository->getDates();
        $times = [];
        if ($paramDate) {
            $times = $this->stockDataRepository->getTimes($paramDate);
        } else {
            $times = $this->stockDataRepository->getTimes($dates[0]);
        }

        $this->response([
            'data' => [
                'dates' => $dates,
                'times' => $times
            ]
        ]);
    }
}