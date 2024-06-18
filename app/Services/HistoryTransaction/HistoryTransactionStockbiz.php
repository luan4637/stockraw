<?php

namespace App\Services\HistoryTransaction;

use voku\helper\HtmlDomParser;

class HistoryTransactionStockbiz extends AbstractRequest implements HistoryTransactionInterface
{
    const URL = 'https://www.stockbiz.vn/Stocks/[CODE]/HistoricalQuotes.aspx';

    public function __construct()
    {
        parent::__construct(
            new \GuzzleHttp\Client(),
            new \App\Repository\TransactionRepository()
        );
    }

    /**
     * @inheritdoc
     */
    public function parseDomToModel(HtmlDomParser $dom): array
    {
        $dataTable = $dom->findMultiOrFalse('table.dataTable');
        if (!$dataTable) {
            echo 'Table transaction does not found.';
            return [];
        }
        
        $transactionTable = $dataTable[0];
        $transactionRow = $transactionTable->findMulti('tr');
        unset($transactionRow[0]);

        $transactions = [];
        foreach($transactionRow as $row) {
            $cols = $row->findMulti('td');

            $date = trim($cols[0]->text);
            $vol = trim($cols[8]->text);
            $cur = trim($cols[5]->text);
            $open = trim($cols[2]->text);
            $high = trim($cols[3]->text);
            $low = trim($cols[4]->text);

            $date = \createDateFormat($date);
            $vol = (int) str_replace('.', '', $vol);
            $cur = (float) str_replace(',', '.', $cur);
            $open = (float) str_replace(',', '.', $open);
            $high = (float) str_replace(',', '.', $high);
            $low = (float) str_replace(',', '.', $low);

            $transactions[] = [
                'date' => $date,
                'vol' => $vol,
                'cur' => $cur,
                'open' => $open,
                'high' => $high,
                'low' => $low
            ];
        }

        return $transactions;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return self::URL;
    }
}