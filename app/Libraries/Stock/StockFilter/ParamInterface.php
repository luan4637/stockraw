<?php

namespace App\Libraries\Stock\StockFilter;

use CodeIgniter\HTTP\IncomingRequest;

interface ParamInterface
{
    /**
     * @param \App\Models\StockModel[] $stocks
     * @return \App\Models\StockModel[]
     */
    public function getValid(array $stocks);
}