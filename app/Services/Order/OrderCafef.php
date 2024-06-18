<?php

namespace App\Services\Order;

use App\Models\OrderModel;
use voku\helper\HtmlDomParser;

class OrderCafef extends AbstractRequest implements OrderInterface
{
    const URL = 'https://s.cafef.vn/Lich-su-giao-dich-[CODE]-6.chn';
    const URL_AJAX = 'https://s.cafef.vn/Ajax/PageNew/DataHistory/KhopLenh/DataKhopLenh.ashx?Symbol=[CODE]&Date=[DATE]';

    public function __construct()
    {
        parent::__construct(
            new \GuzzleHttp\Client(),
            new HtmlDomParser()
        );
    }

    /**
     * @inheritdoc
     */
    public function parseDomToModel(HtmlDomParser $dom): array
    {
        if (!isset($dom->find('#tblData')[0])) {
            echo 'Table orderStatistics does not found.';
            return [];
        }
        
        $transactionTable = $dom->find('#tblData')[0];
        $transactionRow = $transactionTable->find('tr');

        $orderStatisticses = [];
        foreach($transactionRow as $row) {
            $cols = $row->find('td');

            $time = trim($cols[0]->text);
            $price = trim($cols[1]->text);
            $volOrder = trim($cols[2]->text);
            $volCount = trim($cols[3]->text);
            $proportion = trim($cols[4]->text);

            $time = $time;
            $price = (float) $price;
            $volOrder = (int) str_replace(',', '', $volOrder);
            $volCount = (int) str_replace(',', '', $volCount);
            $proportion = trim(str_replace('(%)', '', $proportion));

            $orderStatisticses[] = (new OrderModel())->fill([
                'time' => $time,
                'price' => $price,
                'volOrder' => $volOrder * 10,
                'volCount' => $volCount * 10,
                'proportion' => $proportion
            ]);
        }

        return $orderStatisticses;
    }

    /**
     * @inheritdoc
     */
    public function factoryModel(array $data): array
    {
        $results = [];
        foreach ($data as $item) {
            $results[] = (new OrderModel())->fill([
                'time' => $item['ThoiGian'],
                'price' => $item['Gia'],
                'volOrder' => ceil($item['KLLo']) * 10,
                'volCount' => ceil($item['KLTichLuy']) * 10,
                'proportion' => $item['TiTrong']
            ]);
        }

        return $results;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return self::URL;
    }

    /**
     * @inheritdoc
     */
    public function getUrlAjax(): string
    {
        return self::URL_AJAX;
    }
}