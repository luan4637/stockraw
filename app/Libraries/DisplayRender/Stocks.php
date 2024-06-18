<?php

namespace App\Libraries\DisplayRender;

use App\Models\StockModel;

class Stocks
{
    /**
     * @return array
     */
    public function getColumnsDisplayed(): array
    {
        return [
            // ['name' => 'code', 'type' => 'text', 'width' => '40px'],
            ['name' => 'exchange', 'type' => 'text', 'width' => '40px'],
            ['name' => 'TC', 'type' => 'text', 'width' => '45px'],
            ['name' => 'cur', 'type' => 'text', 'width' => '45px'],
            ['name' => 'percent', 'type' => 'text', 'width' => '50px'],
            ['name' => 'volPercent', 'type' => 'text', 'width' => '60px'],
            ['name' => 'vol', 'type' => 'text'],
            ['name' => 'volYesterday', 'type' => 'text'],
            ['name' => 'volTwoDayAgo', 'type' => 'text'],
            ['name' => 'volThreeDayAgo', 'type' => 'text'],
            ['name' => 'groupName', 'type' => 'text', 'width' => '160px'],
        ];
    }

    /**
     * @return array
     */
    public function getColumnsReportDisplay(): array
    {
        return [
            // ['name' => 'code', 'type' => 'text', 'width' => '60px'],
            ['name' => 'exchange', 'type' => 'text', 'width' => '60px'],
            ['name' => 'cur', 'type' => 'text', 'width' => '70px'],
            ['name' => 'cur1Ago', 'type' => 'text', 'width' => '70px'],
            ['name' => 'cur2Ago', 'type' => 'text', 'width' => '70px'],
            ['name' => 'cur3Ago', 'type' => 'text', 'width' => '70px'],
            ['name' => 'cur4Ago', 'type' => 'text', 'width' => '70px'],
            ['name' => 'cur5Ago', 'type' => 'text', 'width' => '70px'],
            ['name' => 'groupName', 'type' => 'text', 'width' => '160px'],
            // ['name' => 'groupDes', 'type' => 'text'],
        ];
    }

    /**
     * @return array
     */
    public function getColumnsChangeDisplay(): array
    {
        return [
            // ['name' => 'code', 'type' => 'text', 'width' => '60px'],
            ['name' => 'exchange', 'type' => 'text', 'width' => '60px'],
            ['name' => 'cur', 'type' => 'text'],
            ['name' => 'vol', 'type' => 'text'],
            ['name' => 'volYesterday', 'type' => 'text'],
            ['name' => 'volTwoDayAgo', 'type' => 'text'],
            ['name' => 'volThreeDayAgo', 'type' => 'text'],
            ['name' => 'avg', 'type' => 'text', 'width' => '60px'],
            ['name' => 'groupName', 'type' => 'text', 'width' => '160px'],
            // ['name' => 'groupDes', 'type' => 'text'],
        ];
    }

    /**
     * @param StockModel[] $stocks
     * @return array
     */
    public function render(array $stocks): array
    {
        $results = [];

        foreach ($stocks as $stock) {
            $newStock = $stock->jsonSerialize();
            $newStock['vol'] = number_format($newStock['vol']);
            $newStock['percent'] = number_format($newStock['percent'], 2);
            $newStock['volPercent'] = number_format($newStock['volPercent']);
            $newStock['volYesterday'] = number_format($newStock['volYesterday']);
            $newStock['volTwoDayAgo'] = number_format($newStock['volTwoDayAgo']);
            $newStock['volThreeDayAgo'] = number_format($newStock['volThreeDayAgo']);

            $newStock['vol1Ago'] = number_format($newStock['vol1Ago']);
            $newStock['vol2Ago'] = number_format($newStock['vol2Ago']);
            $newStock['vol3Ago'] = number_format($newStock['vol3Ago']);
            $newStock['vol4Ago'] = number_format($newStock['vol4Ago']);
            $newStock['vol5Ago'] = number_format($newStock['vol5Ago']);

            $newStock['cur1Ago'] = number_format($newStock['cur1Ago'], 2);
            $newStock['cur2Ago'] = number_format($newStock['cur2Ago'], 2);
            $newStock['cur3Ago'] = number_format($newStock['cur3Ago'], 2);
            $newStock['cur4Ago'] = number_format($newStock['cur4Ago'], 2);
            $newStock['cur5Ago'] = number_format($newStock['cur5Ago'], 2);

            if (isset($newStock['avg'])) {
                $newStock['avg'] = number_format($newStock['avg'], 2);
            }
            
            $results[] = $newStock;
        }

        return $results;
    }
}