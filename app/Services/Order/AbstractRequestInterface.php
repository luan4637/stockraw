<?php

namespace App\Services\Order;

use App\Models\OrderModel;

interface AbstractRequestInterface
{
    /**
     * @param string $code
     * @return OrderModel[]
     */
    public function request(string $code): array;

    /**
     * @param string $code
     * @param string $date
     * @return OrderModel[]
     */
    public function requestAjax(string $code, string $date): array;
}