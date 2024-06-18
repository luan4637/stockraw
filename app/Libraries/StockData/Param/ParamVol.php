<?php

namespace App\Libraries\StockData\Param;

use App\Libraries\StockData\Condition\ConditionInterface;
use CodeIgniter\HTTP\IncomingRequest;

class ParamVol implements ParamInterface
{
    const PARAM_KEY = 'vol';
    const DEFAULT_VALUE = 50000;

    /** @var IncomingRequest */
    private $request;
    /** @var ConditionInterface */
    private $condition;

    /**
     * @param IncomingRequest $request
     * @param ConditionInterface $condition
     */
    public function __construct(IncomingRequest $request, ConditionInterface $condition)
    {
        $this->request = $request;
        $this->condition = $condition;
    }

    /**
     * @inheritdoc
     */
    public function getConditionClause(): string
    {
        return self::PARAM_KEY . ' ' . $this->condition->getCondition();
    }

    /**
     * @inheritdoc
     */
    public function getValue(): int
    {
        $value = (int) $this->request->getVar(self::PARAM_KEY);

        if (!$value) {
            $value = self::DEFAULT_VALUE;
        }

        return $value;
    }
}