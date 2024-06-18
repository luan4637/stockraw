<?php

namespace App\Libraries\Stock\StockFilter\Condition;

use App\Models\StockModel;
use CodeIgniter\HTTP\IncomingRequest;

class ConditionLessThan implements ConditionInterface
{
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
    public function filterResults(array $stocks, string $keyParam)
    {
        $compareValue = $this->request->getVar($keyParam);

        $results = [];
        foreach ($stocks as $stock) {
            if ($stock->$keyParam < $compareValue) {
                $results[] = $stock;
            }
        }
        return $results;
    }
}