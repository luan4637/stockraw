<?php

namespace App\Repository;

use App\Libraries\StockData\FilterInterface;
use App\Libraries\StockData\Param\ParamDate;
use App\Libraries\StockData\Param\ParamTime;
use App\Libraries\StockData\SortOrderInterface;
use App\Repository\Cache\StockDataRepositoryInterface;

class StockDataRepository implements StockDataRepositoryInterface
{
    /** @var \CodeIgniter\Database\BaseBuilder */
    private $builder;
    /** @var \App\Models\StockDataModel */
    private $stockDataModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->stockDataModel = model('App\Models\StockDataModel');
        $this->builder = $db->table($this->stockDataModel->getTableName() . ' AS s');
    }

    /**
     * @inheritdoc
     */
    public function getLastestStockData(FilterInterface $filter, SortOrderInterface $sortOrder): array
    {
        $lastStock = $this->getLastestRecord();
        // if (!$lastStock) {
        //     return [];
        // }

        // $filterCreatedAt = $lastStock['createdAt'];
        // $filterCreatedTime = $lastStock['createdTime'];
        
        $this->builder->select('s.*, t.yesterday, t.twoDayAgo, t.threeDayAgo, c.des, c.groupId');

        foreach ($filter->getFilters() as $filterParam) {
            if ($filterParam instanceof ParamDate || $filterParam instanceof ParamTime) {
                if ($filterParam->getValue()) {
                    $this->builder->where($filterParam->getConditionClause(), $filterParam->getValue());
                } else {
                    if ($filterParam instanceof ParamDate) {
                        $filterCreatedAt = $lastStock['createdAt'];
                        $this->builder->where($filterParam->getConditionClause(), $filterCreatedAt);
                    }
                    if ($filterParam instanceof ParamTime) {
                        $filterCreatedTime = $lastStock['createdTime'];
                        $this->builder->where($filterParam->getConditionClause(), $filterCreatedTime);
                    }
                }
            } else {
                if ($filterParam->getConditionClause()) {
                    $this->builder->where($filterParam->getConditionClause(), $filterParam->getValue());
                }
            }
        }

        $this->builder->join(\App\Models\TransactionTmpModel::TABLE_NAME . ' AS t', 's.code = t.code');
        $this->builder->join(\App\Models\CodeModel::TABLE_NAME . ' AS c', 'c.name = s.code');

        $this->builder->orderBy($sortOrder->getSort(), $sortOrder->getOrder());

        // echo $this->builder->getCompiledSelect(); die;
        
        return $this->builder->get()->getResultArray();
    }

    /**
     * @return array
     */
    private function getLastestRecord()
    {
        $this->builder->select('s.*');
        $this->builder->where('createdAt', \getWeekday());
        $this->builder->where('id = (SELECT MAX(id) FROM ' . $this->stockDataModel->getTableName() . ')');

        $lastRecord = $this->builder->get()->getResultArray();
        
        return $lastRecord[0] ?? [ 'createdAt' => \getWeekday(), 'createdTime' => '00:00:00' ];
    }

    /**
     * @inheritdoc
     */
    public function getLastestStockDataNoCache(FilterInterface $filter, SortOrderInterface $sortOrder): array
    {
        return $this->getLastestStockData($filter, $sortOrder);
    }

    /**
     * @inheritdoc
     */
    public function getDates(): array
    {
        $this->builder->select('createdAt');
        $this->builder->orderBy('createdAt', 'desc');
        $this->builder->groupBy('s.createdAt');

        return array_column($this->builder->get()->getResultArray(), 'createdAt');
    }

    /**
     * @inheritdoc
     */
    public function getTimes(string $date): array
    {
        $this->builder->select('createdTime');
        $this->builder->where('createdAt', $date);
        $this->builder->orderBy('createdTime', 'desc');
        $this->builder->groupBy('s.createdTime');

        $dates = array_column($this->builder->get()->getResultArray(), 'createdTime');

        $results = [];
        foreach ($dates as $item) {
            $results[substr($item, 0, 4)] = $item;
        }

        return array_values($results);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return $this->stockDataModel->insert($data);
    }
}