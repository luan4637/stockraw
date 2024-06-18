<?php

namespace App\Controllers;

use App\Libraries\DisplayRender\Stocks as DisplayRenderStocks;
use App\Libraries\Stock\StockFilter;
use App\Libraries\Stock\StockMoreInfo;
use App\Models\StockModel;
use App\Services\Exchange\ExchangeVps;
use App\Services\HistoryTransaction\HistoryTransactionStockbiz;
use Config\Services;

class ApiStock extends BaseController
{
    /** @var ExchangeVps */
    private $exchangeService;
    /** @var array */
    private $codes;
    /** @var StockMoreInfo */
    private $stockMoreInfo;
    /** @var DisplayRenderStocks */
    private $displayRenderStocks;

    public function __construct()
    {
        $this->exchangeService = new ExchangeVps();
        $this->historyTransaction = new HistoryTransactionStockbiz();
        $this->codes = array_merge(...array_values(Services::stockExchanges()->getStockExchanges()));
        $this->stockMoreInfo = new StockMoreInfo();
        $this->displayRenderStocks = new DisplayRenderStocks();
    }

    public function index()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\ParamPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVol($this->request),
            new \App\Libraries\Stock\StockFilter\ParamGroupName($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVolPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamSortOrder($this->request)
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->exchangeService->request($this->codes);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        /** @var array $results */
        $results = $this->displayRenderStocks->render($results);

        $this->response($results);
    }

    public function listStocks()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\ParamPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVol($this->request),
            new \App\Libraries\Stock\StockFilter\ParamGroupName($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVolPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamSortOrder($this->request)
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->getLastStocks();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        /** @var array $results */
        $results = $this->displayRenderStocks->render($results);

        $this->response($results);
    }

    public function countGroupBK()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\ParamPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVol($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVolPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamSortOrder($this->request)
        ]);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->exchangeService->request($this->codes);
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        
        $groups = [];
        foreach ($results as $result) {
            $groupName = trim($result->groupName);
            if (empty($groupName)) {
                continue;
            }
            if (!isset($groups[$groupName])) {
                $groups[$groupName] = 1;
            } else {
                $groups[$groupName] += 1;
            }
        }

        $this->response($groups);
    }

    public function countGroup()
    {
        /** @var StockFilter $stockFilter */
        $stockFilter = new StockFilter([
            new \App\Libraries\Stock\StockFilter\ParamPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVol($this->request),
            new \App\Libraries\Stock\StockFilter\ParamVolPercent($this->request),
            new \App\Libraries\Stock\StockFilter\ParamSortOrder($this->request)
        ]);

        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->getLastStocks();
        /** @var \App\Models\StockModel[] $stocks */
        $stocks = $this->stockMoreInfo->addMoreInfo($stocks);
        /** @var \App\Models\StockModel[] $stocks */
        $results = $stockFilter->filter($stocks);
        
        $groups = [];
        foreach ($results as $result) {
            $groupName = trim($result->groupName);
            if (empty($groupName)) {
                continue;
            }
            if (!isset($groups[$groupName])) {
                $groups[$groupName] = 1;
            } else {
                $groups[$groupName] += 1;
            }
        }

        $this->response($groups);
    }

    /**
     * @return StockModel[]
     */
    private function getLastStocks(): array
    {
        /** @var string $storeDir */
        $storeDir = Services::path()->writableDirectory . '/capture/' . date('Ymd');
        $filePaths = (array) glob("$storeDir/*.json", GLOB_BRACE);

        $files = [];
        foreach ($filePaths as $filePath) {
            if (preg_match('/_(.*?).json/', $filePath, $match) == 1) {
                $files[$match[1]] = $filePath;
            }
        }
        ksort($files, SORT_NUMERIC);
        $lastDataPath = end($files);
        /** @var string $stocksJson */
        $stocksJson = file_get_contents($lastDataPath);
        /** @var array $stocks */
        $stocks = json_decode($stocksJson);

        foreach ($stocks as &$stock) {
            $stock = (new StockModel())->fill((array) $stock);
        }

        return $stocks;
    }
}
