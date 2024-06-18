<?php

namespace App\Libraries\Order;

interface SortOrderInterface
{
    /**
     * @return string
     */
    public function getSort(): string;

    /**
     * @return string
     */
    public function getOrder(): string;
}