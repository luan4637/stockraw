<?php

namespace App\Services\Financial;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use PHPHtmlParser\Dom;

abstract class AbstractRequest
{
    /** @var Client $httpClient */
    private $httpClient;

    /** @var Dom $dom */
    private $dom;

    /**
     * @param Client $httpClient
     * @param Dom $dom
     */
    public function __construct(Client $httpClient, Dom $dom)
    {
        $this->httpClient = $httpClient;
        $this->dom = $dom;
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
        $results = Promise\settle($promises)->wait();

        $financials = [];
        foreach ($results as $code => $result) {
            if (isset($result['value'])) {
                $response = $result['value'];
                if ($response->getStatusCode() === 200) {
                    $this->dom->loadStr($response->getBody());
                    $financials[$code] = $this->parseDomToModel($this->dom);
                }
            }
        }

        return $financials;
    }
    
    abstract public function parseDomToModel($dom): array;

    abstract public function getUrl(): string;
}