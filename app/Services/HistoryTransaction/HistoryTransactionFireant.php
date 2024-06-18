<?php

namespace App\Services\HistoryTransaction;

use App\Commands\GetTokenStockbiz;
use App\Repository\TransactionRepository;
use CodeIgniter\Cache\CacheInterface;
use Config\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class HistoryTransactionFireant
{
    const URL = 'https://restv2.fireant.vn/symbols/[CODE]/historical-quotes?startDate=[START_DATE]&endDate=[END_DATE]&offset=0&limit=15';
    const AUTHORIZATION = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IkdYdExONzViZlZQakdvNERWdjV4QkRITHpnSSIsImtpZCI6IkdYdExONzViZlZQakdvNERWdjV4QkRITHpnSSJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmZpcmVhbnQudm4iLCJhdWQiOiJodHRwczovL2FjY291bnRzLmZpcmVhbnQudm4vcmVzb3VyY2VzIiwiZXhwIjoxODg5NjIyNTMwLCJuYmYiOjE1ODk2MjI1MzAsImNsaWVudF9pZCI6ImZpcmVhbnQudHJhZGVzdGF0aW9uIiwic2NvcGUiOlsiYWNhZGVteS1yZWFkIiwiYWNhZGVteS13cml0ZSIsImFjY291bnRzLXJlYWQiLCJhY2NvdW50cy13cml0ZSIsImJsb2ctcmVhZCIsImNvbXBhbmllcy1yZWFkIiwiZmluYW5jZS1yZWFkIiwiaW5kaXZpZHVhbHMtcmVhZCIsImludmVzdG9wZWRpYS1yZWFkIiwib3JkZXJzLXJlYWQiLCJvcmRlcnMtd3JpdGUiLCJwb3N0cy1yZWFkIiwicG9zdHMtd3JpdGUiLCJzZWFyY2giLCJzeW1ib2xzLXJlYWQiLCJ1c2VyLWRhdGEtcmVhZCIsInVzZXItZGF0YS13cml0ZSIsInVzZXJzLXJlYWQiXSwianRpIjoiMjYxYTZhYWQ2MTQ5Njk1ZmJiYzcwODM5MjM0Njc1NWQifQ.dA5-HVzWv-BRfEiAd24uNBiBxASO-PAyWeWESovZm_hj4aXMAZA1-bWNZeXt88dqogo18AwpDQ-h6gefLPdZSFrG5umC1dVWaeYvUnGm62g4XS29fj6p01dhKNNqrsu5KrhnhdnKYVv9VdmbmqDfWR8wDgglk5cJFqalzq6dJWJInFQEPmUs9BW_Zs8tQDn-i5r4tYq2U8vCdqptXoM7YgPllXaPVDeccC9QNu2Xlp9WUvoROzoQXg25lFub1IYkTrM66gJ6t9fJRZToewCt495WNEOQFa_rwLCZ1QwzvL0iYkONHS_jZ0BOhBCdW9dWSawD6iF1SIQaFROvMDH1rg';

    /** @var Client $httpClient */
    private $httpClient;

    /** @var TransactionRepository */
    private $transactionRepository;
    
    /** @var CacheInterface */
    private $cache;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->transactionRepository = new TransactionRepository();
        $this->cache = Services::cache();
    }

    /**
     * @param array $code
     * @return array
     */
    public function request(array $codes)
    {
        $token = self::AUTHORIZATION;
        if ($this->cache->get(GetTokenStockbiz::TOKEN)) {
            $token = 'Bearer ' . $this->cache->get(GetTokenStockbiz::TOKEN);
        }

        $promises = [];
        foreach ($codes as $code) {
            $requestUrl = str_replace(
                ['[CODE]', '[START_DATE]', '[END_DATE]'],
                [$code, date('Y-m-d', strtotime('-7 days')), date('Y-m-d')], 
                self::URL
            );
            $promises[$code] = $this->httpClient->request(
                'GET',
                $requestUrl, 
                [
                    'verify' => false,
                    'headers' => ['Authorization' => $token]
                ]
            );
        }
        $results = Utils::settle($promises)->wait();

        $successCodes = [];
        $failCodes = [];
        foreach ($results as $code => $result) {
            if (isset($result['value'])) {
                $response = $result['value'];
                if ($response->getStatusCode() === 200) {
                    $dataTransactions = json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
                    if (!empty($dataTransactions) && \json_last_error() === JSON_ERROR_NONE) {
                        $transactions = $this->formatTransaction($dataTransactions);
                        if (count($transactions) > 0) {
                            $lastTransaction = $transactions[0];
                            if (\isWorkingHour()) {
                                $lastTransaction = $transactions[1];
                                unset($transactions[0]);
                            }

                            foreach ($transactions as $transaction) {
                                if ($transaction['vol'] > 0) {
                                    $this->transactionRepository->save($transaction + ['code' => $code]);
                                } else {
                                    $failCodes[] = $code;
                                }
                            }
                            $lastTransactionDate = $lastTransaction['date'];
                            if ($lastTransactionDate != \getWeekday() && $lastTransactionDate != \getWeekday(-1) ) {
                                $failCodes[] = $code;
                            } else {
                                $successCodes[] = $code;
                            }
                            $failCodes = array_unique($failCodes);
                        } else {
                            $failCodes[] = $code;
                        }
                    } else {
                        $failCodes[] = $code;
                    }
                }
            }
        }

        return [
            'successCodes' => $successCodes,
            'failCodes' => $failCodes
        ];
    }

    private function formatTransaction($transactions)
    {
        $results = [];
        foreach($transactions as $transaction) {
            $date = date('Y-m-d', strtotime($transaction['date']));
            $vol = (int) $transaction['totalVolume'];
            $cur = (float) $transaction['priceClose'];
            $open = (float) $transaction['priceOpen'];
            $high = (float) $transaction['priceHigh'];
            $low = (float) $transaction['priceLow'];

            $results[] = [
                'date' => $date,
                'vol' => $vol,
                'cur' => $cur,
                'open' => $open,
                'high' => $high,
                'low' => $low
            ];
        }

        return $results;
    }
}