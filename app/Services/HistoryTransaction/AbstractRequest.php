<?php

namespace App\Services\HistoryTransaction;

use App\Repository\TransactionRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use voku\helper\HtmlDomParser;

abstract class AbstractRequest
{
    /** @var Client $httpClient */
    private $httpClient;

    /** @var TransactionRepository */
    private $transactionRepository;

    /**
     * @param Client $httpClient
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(Client $httpClient, TransactionRepository $transactionRepository)
    {
        $this->httpClient = $httpClient;
        $this->transactionRepository = $transactionRepository;
    }
    
    /**
     * @param array $code
     * @return array
     */
    public function request(array $codes): array
    {
        $promises = [];
        foreach ($codes as $code) {
            $requestUrl = str_replace('[CODE]', $code, $this->getUrl());
            $promises[$code] = $this->httpClient->request(
                'GET',
                $requestUrl, 
                [ 'verify' => false ]
            );
        }
        $results = Utils::settle($promises)->wait();

        $successCodes = [];
        $failCodes = [];
        foreach ($results as $code => $result) {
            if (isset($result['value'])) {
                $response = $result['value'];
                if ($response->getStatusCode() === 200) {
                    /** @var string $contentHtml */
                    $contentHtml = (string) $response->getBody();
                    /** @var HtmlDomParser $dom */
                    $dom = HtmlDomParser::str_get_html($contentHtml);
                    /** @var array $transactions */
                    $transactions = $this->parseDomToModel($dom);
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
                }
            }
        }

        return [
            'successCodes' => $successCodes,
            'failCodes' => $failCodes
        ];
    }
    
    abstract public function parseDomToModel(HtmlDomParser $dom): array;

    abstract public function getUrl(): string;
}