<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repository\GroupRepository;
use App\Repository\Cache\StockDataRepositoryCache;
use App\Repository\Cache\StockDataRepositoryInterface;

class ApiGroup extends BaseController
{
    /** @var GroupRepository */
    private $groupRepository;
    /** @var StockDataRepositoryInterface */
    private $stockDataRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
        $this->stockDataRepository = new StockDataRepositoryCache();
    }

    public function groupActivedList()
    {
        /** @var array $groups */
        // $groups = $this->groupRepository->getActivedList(
        //     model('App\Models\StockDataModel'),
        //     new \App\Libraries\StockData\Filter([
        //         new \App\Libraries\StockData\Param\ParamPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
        //         new \App\Libraries\StockData\Param\ParamVol($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
        //         new \App\Libraries\StockData\Param\ParamVolPercent($this->request, new \App\Libraries\StockData\Condition\ConditionGreaterEqual()),
        //         new \App\Libraries\StockData\Param\ParamGroupId($this->request, new \App\Libraries\StockData\Condition\ConditionEqual()),
        //     ])
        // );

        /** @var array $groups */
        $groups = $this->groupRepository->getAll();
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

        $countStocks = [];
        foreach ($stockDatas as $stockData) {
            if (isset($countStocks[$stockData['groupId']]) ) {
                $countStocks[$stockData['groupId']] += 1;
            } else {
                $countStocks[$stockData['groupId']] = 1;
            }
        }

        $results = [];
        foreach ($groups as $group) {
            $groupId = $group['id'];
            if (isset($countStocks[$groupId]) ) {
                $group['totalStock'] = $countStocks[$groupId];
                $results[] = $group;
            }
        }

        $total = 0;
        foreach (array_column($results, 'totalStock') as $totalItem) {
            $total += $totalItem;
        }
        $this->response([
            'total' => $total,
            'data' => $results
        ]);
    }
}