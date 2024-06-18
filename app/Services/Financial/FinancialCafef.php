<?php

namespace App\Services\Financial;

use App\Models\FinancialModel;

class FinancialCafef extends AbstractRequest implements FinancialInterface
{
    const URL = 'https://s.cafef.vn/Ajax/HoSoCongTy.aspx?symbol=[CODE]&PageIndex=0&PageSize=4';

    public function __construct()
    {
        parent::__construct(
            new \GuzzleHttp\Client(),
            new \PHPHtmlParser\Dom()
        );
    }

    /**
     * @inheritdoc
     */
    public function parseDomToModel($dom): array
    {
        if (!isset($dom->find('table')[0])) {
            echo 'Table does not found.';
            return [];
        }
        $table = $dom->find('table')[0];
        $rows = $table->find('tr');

        $results = [];
        for($i = 1; $i <= 4; $i++) {
            $date = $rows[0]->find('th')[$i]->text;
            $value = $rows[8]->find('td')[$i]->text;

            $financial = (new FinancialModel)->fill([
                'date' => $date,
                'value' => $value
            ]);
            $results[$date] = $financial;
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
}