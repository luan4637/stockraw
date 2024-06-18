<?php

namespace App\Services\Order;

use App\Models\OrderModel;
use voku\helper\HtmlDomParser;

interface OrderInterface extends AbstractRequestInterface
{
    /**
     * @param HtmlDomParser $dom
     * @return OrderModel[]
     */
    public function parseDomToModel(HtmlDomParser $dom): array;

    /**
     * @param array $data
     * @return OrderModel[]
     */
    public function factoryModel(array $data): array;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return string
     */
    public function getUrlAjax(): string;
}