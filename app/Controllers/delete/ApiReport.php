<?php

namespace App\Controllers;

use App\Libraries\DisplayRender\Stocks as DisplayRenderStocks;
use App\Libraries\Stock\StockFilter;
use App\Libraries\Stock\StockMoreInfo;
use App\Libraries\Transaction\Filters\FilterToday;
use App\Libraries\Transaction\TransactionFilter;
use App\Services\HistoryTransaction\HistoryTransactionStockbiz;
use Config\Services;

class ApiReport extends BaseController
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
            new FilterToday()
        ]);
    }

    public function report3up()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\Condition3up()
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->buildStockModel();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        /** @var array $results */
        $results = $this->displayRenderStocks->render($results);

        $this->response($results);
    }

    public function report3up1down()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\Condition3up1down()
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->buildStockModel();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        /** @var array $results */
        $results = $this->displayRenderStocks->render($results);

        $this->response($results);
    }

    public function report3up2down()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\Condition3up2down()
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->buildStockModel();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
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
                'cur' => $this->transactionFilterToday->getCur($code)
            ]);
        }

        return $stocks;
    }
}
