<?php

namespace App\Controllers;

use App\Libraries\DisplayRender\Stocks as DisplayRenderStocks;
use App\Repository\Cache\StockDataRepositoryCache;
use App\Repository\Cache\StockDataRepositoryInterface;

class Home extends BaseController
{
    /** @var DisplayRenderStocks */
    private $displayRenderStocks;
    /** @var StockDataRepositoryInterface */
    private $stockDataRepository;

    public function __construct()
    {
        $this->displayRenderStocks = new DisplayRenderStocks();
        $this->stockDataRepository = new StockDataRepositoryCache();
    }

    public function index()
    {
        return view ('home', [

        ]);
    }

    public function history()
    {
        $dates = $this->stockDataRepository->getDates();
        return view ('history', [
            'dates' => $dates,
            'times' => $this->stockDataRepository->getTimes($dates[0]),
        ]);
    }

    public function report()
    {
        return view ('report', [

        ]);
    }

    public function order()
    {
        return view ('order', [

        ]);
    }

    public function fluctuation()
    {
        return view ('fluctuation', [

        ]);
    }
}
