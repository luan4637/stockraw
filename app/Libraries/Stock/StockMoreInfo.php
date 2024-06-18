<?php

namespace App\Libraries\Stock;

use App\Libraries\Transaction\Filters\FilterYesterday;
use App\Libraries\Transaction\Filters\FilterTwoDayAgo;
use App\Libraries\Transaction\Filters\FilterThreeDayAgo;
use App\Libraries\Transaction\Filters\FilterFourDayAgo;
use App\Libraries\Transaction\Filters\FilterFiveDayAgo;
use App\Libraries\Transaction\Filters\FilterSixDayAgo;
use App\Libraries\Transaction\TransactionFilter;
use App\Models\StockModel;

class StockMoreInfo
{
    /** @var TransactionFilter */
    private $transactionFilterYesterday;
    /** @var TransactionFilter */
    private $transactionFilterTwoDayAgo;
    /** @var TransactionFilter */
    private $transactionFilterThreeDayAgo;
    /** @var TransactionFilter */
    private $transaction1Ago;
    /** @var TransactionFilter */
    private $transaction2Ago;
    /** @var TransactionFilter */
    private $transaction3Ago;
    /** @var TransactionFilter */
    private $transaction4Ago;
    /** @var TransactionFilter */
    private $transaction5Ago;
    /** @var TransactionFilter */
    private $transaction6Ago;
    /** @var \Config\StockGroups */
    private $stockGroups;
    /** @var \App\Models\GroupModel */
    private $groupModel;
    /** @var \App\Models\CodeModel */
    private $codeModel;

    public function __construct()
    {
        $this->transactionFilterYesterday = new TransactionFilter([
            new FilterYesterday()
        ]);
        $this->transactionFilterTwoDayAgo = new TransactionFilter([
            new FilterYesterday(),
            new FilterTwoDayAgo()
        ]);
        $this->transactionFilterThreeDayAgo = new TransactionFilter([
            new FilterYesterday(),
            new FilterTwoDayAgo(),
            new FilterThreeDayAgo()
        ]);
        $this->transaction1Ago = new TransactionFilter([
            new FilterYesterday()
        ]);
        $this->transaction2Ago = new TransactionFilter([
            new FilterTwoDayAgo()
        ]);
        $this->transaction3Ago = new TransactionFilter([
            new FilterThreeDayAgo()
        ]);
        $this->transaction4Ago = new TransactionFilter([
            new FilterFourDayAgo()
        ]);
        $this->transaction5Ago = new TransactionFilter([
            new FilterFiveDayAgo()
        ]);
        $this->transaction6Ago = new TransactionFilter([
            new FilterSixDayAgo()
        ]);
        $this->stockGroups = new \Config\StockGroups();
        $this->groupModel = model('App\Models\GroupModel');
        $this->codeModel = model('App\Models\CodeModel');
    }

    /**
     * @param StockModel[] $stocks
     * @return StockModel[]
     */
    public function addMoreInfo(array $stocks): array
    {
        foreach ($stocks as &$stock) {
            $stock->volYesterday = $this->transactionFilterYesterday->getTotalVol($stock->code);
            $stock->volTwoDayAgo = $this->transactionFilterTwoDayAgo->getTotalVol($stock->code);
            $stock->volThreeDayAgo = $this->transactionFilterThreeDayAgo->getTotalVol($stock->code);
            
            $stock->vol1Ago = $this->transaction1Ago->getTotalVol($stock->code);
            $stock->vol2Ago = $this->transaction2Ago->getTotalVol($stock->code);
            $stock->vol3Ago = $this->transaction3Ago->getTotalVol($stock->code);
            $stock->vol4Ago = $this->transaction4Ago->getTotalVol($stock->code);
            $stock->vol5Ago = $this->transaction5Ago->getTotalVol($stock->code);
            $stock->vol6Ago = $this->transaction6Ago->getTotalVol($stock->code);

            $stock->cur1Ago = $this->transaction1Ago->getCur($stock->code);
            $stock->cur2Ago = $this->transaction2Ago->getCur($stock->code);
            $stock->cur3Ago = $this->transaction3Ago->getCur($stock->code);
            $stock->cur4Ago = $this->transaction4Ago->getCur($stock->code);
            $stock->cur5Ago = $this->transaction5Ago->getCur($stock->code);
            $stock->cur6Ago = $this->transaction6Ago->getCur($stock->code);

            $stock->percent = $stock->cur ? ($stock->cur - $stock->TC) / $stock->cur * 100 : 0;
            $stock->volPercent = $stock->volYesterday ? $stock->vol / $stock->volYesterday * 100 : 0;

            $codeObj = $this->codeModel->where('name', $stock->code)->first();
            $groupObj = $this->groupModel->find($codeObj['groupId'] ?? '');
            $stock->exchange = $codeObj['exchange'] ?? '';
            $stock->groupName = $groupObj['name'] ?? '';
            $stock->groupDes = $codeObj['des'] ?? '';
        }

        return $stocks;
    }
}