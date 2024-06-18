<?php

namespace App\Services\HistoryTransaction;

use App\Models\TransactionModel;

class HistoryTransactionCafef extends AbstractRequest implements HistoryTransactionInterface
{
    const URL = 'https://s.cafef.vn/Lich-su-giao-dich-[CODE]-1.chn';

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
    public function parseDomToModel($dom): array
    {
        if (!isset($dom->find('#render-table-owner')[0])) {
            echo 'Table transaction does not found.';
            return [];
        }
        
        $transactionTable = $dom->find('#render-table-owner')[0];
        $transactionRow = $transactionTable->find('tr');
        unset($transactionRow[0]);
        unset($transactionRow[1]);

        $transactions = [];
        foreach($transactionRow as $row) {
            $cols = $row->find('td');

            $date      = trim($cols[0]->text);
            $khoiLuong = trim($cols[4]->text);
            $gia       = trim($cols[2]->text);
            $giaMo     = trim($cols[8]->text);
            $giaCao    = trim($cols[9]->text);
            $giaThap   = trim($cols[10]->text);

            $date      = $this->createDateFormat($date);
            $khoiLuong = (int) str_replace('.', '', $khoiLuong);
            $gia       = (float) str_replace(',', '.', $gia);
            $giaMo     = (float) str_replace(',', '.', $giaMo);
            $giaCao    = (float) str_replace(',', '.', $giaCao);
            $giaThap   = (float) str_replace(',', '.', $giaThap);

            $transactions[] = (new TransactionModel)->fill([
                'date' => $date,
                'vol' => $khoiLuong,
                'cur' => $gia,
                'open' => $giaMo,
                'high' => $giaCao,
                'low' => $giaThap
            ]);
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

    private function createDateFormat($datetime, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
    {
        $timestamp = \DateTime::createFromFormat('!' . $fromFormat, $datetime)->getTimestamp();
    
        return date($toFormat, $timestamp);
    }
}