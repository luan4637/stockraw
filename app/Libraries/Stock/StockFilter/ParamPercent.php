<?php

namespace App\Libraries\Stock\StockFilter;

use App\Libraries\Stock\StockFilter\Condition\ConditionInterface;
use App\Libraries\Stock\StockFilter\Condition\ConditionGreateThan;
use CodeIgniter\HTTP\IncomingRequest;

class ParamPercent implements ParamInterface
{
    const FILTER_KEY = 'percent';

    /** @var IncomingRequest */
    private $request;
    /** @var ConditionInterface */
    private $condition;

    /**
     * @param IncomingRequest $request
     * @param ConditionInterface $condition
     */
    public function __construct(IncomingRequest $request, ConditionInterface $condition = null)
    {
        $this->request = $request;
        $this->condition = $condition;
        if ($this->condition == null) {
            $this->condition = new ConditionGreateThan($request);
        }
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

        return $this->condition->filterResults($stocks, self::FILTER_KEY);
    }
}