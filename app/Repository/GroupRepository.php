<?php

namespace App\Repository;

use App\Libraries\StockData\FilterInterface;
use App\Models\StockDataModel;

class GroupRepository
{
    /** @var \CodeIgniter\Database\BaseBuilder */
    private $builder;
    /** @var \App\Models\GroupModel */
    private $groupModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $this->builder = $db->table('groups AS g');
        $this->groupModel = model('App\Models\GroupModel');
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->groupModel->findAll();
    }

    /**
     * @param StockDataModel $stockDataModel
     * @param FilterInterface $filter
     * @return array
     */
    public function getActivedList(StockDataModel $stockDataModel, FilterInterface $filter): array
    {
        $lastStock = $stockDataModel->orderBy('createdAt', 'desc')->orderBy('createdTime', 'desc')->first();
        if (!$lastStock || $lastStock['createdAt'] != \getWeekday()) {
            return [];
        }

        $this->builder->select('g.*, COUNT(s.id) as totalStock');
        $this->builder->where('s.createdAt', $lastStock['createdAt']);
        $this->builder->where('s.createdTime', $lastStock['createdTime']);

        foreach ($filter->getFilters() as $filter) {
            if ($filter->getConditionClause()) {
                $this->builder->where($filter->getConditionClause(), $filter->getValue());
            }
        }

        $this->builder->join('codes AS c', 'c.groupId = g.id', 'left');
        $this->builder->join('stock_data AS s', 's.code = c.name', 'left');
        $this->builder->join('transaction_view AS t', 's.code = t.code');
        $this->builder->groupBy('g.id');

        // echo $this->builder->getCompiledSelect(); die;

        return $this->builder->get()->getResultArray();
    }

    /**
     * @param array $group
     * @return bool
     */
    public function save(array $group): bool
    {
        return $this->groupModel->insert($group, false);
    }
}