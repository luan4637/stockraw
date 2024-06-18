<?php

namespace App\Libraries\Stock;

use App\Libraries\Stock\StockFilter\ParamInterface;
use App\Models\StockModel;

class StockFilter
{
     /** @var ParamInterface[] */
     private $params;

     /**
      * @param array $params
      */
     public function __construct(array $params)
     {
         $this->params = $params;
     }

    /**
     * @param StockModel[] $stocks
     * @return StockModel[]
     */
    public function filter(array $stocks): array
    {
        foreach ($this->params as $param) {
            $stocks = $param->getValid($stocks);
        }
        return $stocks;
    }
}