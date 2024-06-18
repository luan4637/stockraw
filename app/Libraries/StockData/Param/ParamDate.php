<?php

namespace App\Libraries\StockData\Param;

use App\Libraries\StockData\Condition\ConditionInterface;
use CodeIgniter\HTTP\IncomingRequest;

class ParamDate implements ParamInterface
{
    const PARAM_KEY = 'createdAt';

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
    public function getValue(): string
    {
        $value = $this->request->getVar(self::PARAM_KEY) ?? '';

        return $value;
    }
}