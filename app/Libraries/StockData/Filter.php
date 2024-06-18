<?php

namespace App\Libraries\StockData;

class Filter implements FilterInterface
{
    /** @var array */
    private $params;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @inheritdoc
     */
    public function getFilters(): array
    {
        return $this->params;
    }
}