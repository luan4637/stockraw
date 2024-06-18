<?php

namespace App\Libraries\Stock\StockFilter;

use CodeIgniter\HTTP\IncomingRequest;

class ParamVolYesterday implements ParamInterface
{
    const FILTER_KEY = 'volYesterday';
    const DEFAULT_VALUE = 0;

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
            $value = self::DEFAULT_VALUE;
        }
        
        $results = [];
        foreach ($stocks as $stock) {
            if ($stock->$keyParam > $value) {
                $results[] = $stock;
            }
        }
        return $results;
    }
}