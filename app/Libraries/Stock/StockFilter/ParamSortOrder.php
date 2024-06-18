<?php

namespace App\Libraries\Stock\StockFilter;

use CodeIgniter\HTTP\IncomingRequest;

class ParamSortOrder implements ParamInterface
{
    const SORT_KEY = 'sort';
    const ORDER_KEY = 'order';

    /** @var IncomingRequest */
    private $request;

    /**
     * @param IncomingRequest $request
     */
    public function __construct(IncomingRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritdoc
     */
    public function getValid(array $stocks)
    {
        $sort = $this->request->getVar(self::SORT_KEY) ?? 'volPercent';
        $order = strtolower($this->request->getVar(self::ORDER_KEY) ?? 'desc');
        usort($stocks, function ($item1, $item2) use ($sort, $order) {
            if ($order == 'desc') {
                return $item2->$sort <=> $item1->$sort;
            }
            return $item1->$sort <=> $item2->$sort;
        });

        return $stocks;
    }
}