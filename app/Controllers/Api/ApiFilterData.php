<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repository\FilterDataRepository;
use App\Repository\CodeRepository;

class ApiFilterData extends BaseController
{
    /** @var FilterDataRepository */
    private $filterDataRepository;

    /** @var CodeRepository */
    private $codeRepository;

    public function __construct()
    {
        $this->filterDataRepository = new FilterDataRepository();
        $this->codeRepository = new CodeRepository();
    }

    public function filter3up2down()
    {
        $data = $this->filterDataRepository->transactionFor6days();
        $results = [];
        foreach ($data as $row) {
            $prices = json_decode($row['curs'], true);
            ksort($prices);
            $row = array_merge($row, $prices);
            unset($row['curs']);
            $hasData = true;
            for ($i = -5; $i <=0; $i++) {
                $pre6days[] = \getWeekday($i);
                if (!isset($row[\getWeekday($i)])) {
                    $hasData = false;
                }
            }

            if ($hasData) {
                $hour = (int) date('H');
                $dayProcessing = -1;
                if ($hour >= 15) {
                    $dayProcessing = 0;
                }
                $today = floatval($row[\getWeekday($dayProcessing)]);
                $ago1day = floatval($row[\getWeekday($dayProcessing-1)]);
                $ago2day = floatval($row[\getWeekday($dayProcessing-2)]);
                $ago3day = floatval($row[\getWeekday($dayProcessing-3)]);
                $ago4day = floatval($row[\getWeekday($dayProcessing-4)]);
                $ago5day = floatval($row[\getWeekday($dayProcessing-5)]);

                if ($today <= $ago1day
                    && $ago1day <= $ago2day
                    && $ago2day >= $ago3day
                    && $ago3day >= $ago4day
                    && $ago4day >= $ago5day)
                {
                    $codeInfo = $this->codeRepository->getByName($row['code']);
                    $results[] = array_merge($row, $codeInfo);
                }
            }
        }

        $this->response([
            'total' => count($results),
            'data' => $results,
        ]);
    }

    public function filter3up1down()
    {
        $data = $this->filterDataRepository->transactionFor6days();
        $results = [];
        foreach ($data as $row) {
            $prices = json_decode($row['curs'], true);
            ksort($prices);
            $row = array_merge($row, $prices);
            unset($row['curs']);
            $hasData = true;
            for ($i = -5; $i <=0; $i++) {
                $pre6days[] = \getWeekday($i);
                if (!isset($row[\getWeekday($i)])) {
                    $hasData = false;
                }
            }

            if ($hasData) {
                $hour = (int) date('H');
                $dayProcessing = -1;
                if ($hour >= 15) {
                    $dayProcessing = 0;
                }
                $today = floatval($row[\getWeekday($dayProcessing)]);
                $ago1day = floatval($row[\getWeekday($dayProcessing-1)]);
                $ago2day = floatval($row[\getWeekday($dayProcessing-2)]);
                $ago3day = floatval($row[\getWeekday($dayProcessing-3)]);
                $ago4day = floatval($row[\getWeekday($dayProcessing-4)]);

                if ($today <= $ago1day
                    && $ago1day >= $ago2day
                    && $ago2day >= $ago3day
                    && $ago3day >= $ago4day)
                {
                    $results[] = $row;
                }
            }
        }

        $this->response([
            'total' => count($results),
            'data' => $results,
        ]);
    }

    public function filter3up()
    {
        $data = $this->filterDataRepository->transactionFor6days();
        $results = [];
        foreach ($data as $row) {
            $prices = json_decode($row['curs'], true);
            ksort($prices);
            $row = array_merge($row, $prices);
            unset($row['curs']);
            $hasData = true;
            for ($i = -5; $i <=0; $i++) {
                $pre6days[] = \getWeekday($i);
                if (!isset($row[\getWeekday($i)])) {
                    $hasData = false;
                }
            }

            if ($hasData) {
                $hour = (int) date('H');
                $dayProcessing = -1;
                if ($hour >= 15) {
                    $dayProcessing = 0;
                }
                $today = floatval($row[\getWeekday($dayProcessing)]);
                $ago1day = floatval($row[\getWeekday($dayProcessing-1)]);
                $ago2day = floatval($row[\getWeekday($dayProcessing-2)]);
                $ago3day = floatval($row[\getWeekday($dayProcessing-3)]);

                if ($today >= $ago1day
                    && $ago1day >= $ago2day
                    && $ago2day >= $ago3day)
                {
                    $results[] = $row;
                }
            }
        }

        $this->response([
            'total' => count($results),
            'data' => $results,
        ]);
    }
}