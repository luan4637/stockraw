<?php

namespace App\Controllers;

use App\Libraries\DisplayRender\Stocks as DisplayRenderStocks;
use App\Libraries\Stock\StockFilter;
use App\Libraries\Stock\StockMoreInfo;
use App\Libraries\Transaction\TransactionFilter;
use App\Libraries\Transaction\TransactionFilterDaysAgo;
use App\Services\HistoryTransaction\HistoryTransactionStockbiz;
use Config\Services;

class ApiChange extends BaseController
{
    /** @var array */
    private $codes;
    /** @var StockMoreInfo */
    private $stockMoreInfo;
    /** @var DisplayRenderStocks */
    private $displayRenderStocks;
    /** @var TransactionFilter */
    private $transactionFilterToday;

    public function __construct()
    {
        $this->historyTransaction = new HistoryTransactionStockbiz();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->stockMoreInfo = new StockMoreInfo();
        $this->displayRenderStocks = new DisplayRenderStocks();
        $this->transactionFilterToday = new TransactionFilter([
            new \App\Libraries\Transaction\Filters\FilterToday()
        ]);
    }

    public function change5days()
    {
        /** @var TransactionFilterDaysAgo $transactionFilterByDays */
        $transactionFilterByDays = new TransactionFilterDaysAgo($this->request->getVar('day'));
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\ParamVolYesterday($this->request),
            new \App\Libraries\Stock\StockFilter\ParamSortOrder($this->request)
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->buildStockModel();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        foreach ($stocks as &$stock) {
            $stock->avg = $transactionFilterByDays->getCurAverage($stock->code);
        }
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        /** @var array $results */
        $results = $this->displayRenderStocks->render($results);

        $this->response($results);
    }

    /**
     * @return \App\Models\StockModel[]
     */
    private function buildStockModel(): array
    {
        $stocks = [];
        foreach ($this->codes as $code) {
            $stocks[] = (new \App\Models\StockModel)->fill([
                'code' => $code,
                'cur' => $this->transactionFilterToday->getCur($code),
                'vol' => $this->transactionFilterToday->getTotalVol($code)
            ]);
        }

        return $stocks;
    }
}
