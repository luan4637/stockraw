<?php

namespace App\Libraries\Stock\StockFilter;

use CodeIgniter\HTTP\IncomingRequest;

class ParamGroupName implements ParamInterface
{
    const FILTER_KEY = 'groupName';

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
        $keyParam = self::FILTER_KEY;
        $value = $this->request->getVar($keyParam);
        if (!$value) {
            return $stocks;
        }
        
        $results = [];
        foreach ($stocks as $stock) {
            if ($stock->$keyParam == $value) {
                $results[] = $stock;
            }
        }
        return $results;
    }
}