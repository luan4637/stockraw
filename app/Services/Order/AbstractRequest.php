<?php

namespace App\Services\Order;

use GuzzleHttp\Client;
use voku\helper\HtmlDomParser;

abstract class AbstractRequest implements AbstractRequestInterface
{
    /** @var Client $httpClient */
    private $httpClient;

    /**
     * @param Client $httpClient
     * @param HtmlDomParser $dom
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    /**
     * @inheritdoc
     */
    public function request(string $code): array
    {
        $requestUrl = str_replace('[CODE]', $code, $this->getUrl());
        $response = $this->httpClient->request(
            'GET',
            $requestUrl, 
            [ 'verify' => false ]
        );

        $orders = [];
        if ($response->getStatusCode() === 200) {
            /** @var string $contentHtml */
            $contentHtml = (string) $response->getBody();
            /** @var HtmlDomParser $dom */
            $dom = HtmlDomParser::str_get_html($contentHtml);
            /** @var \App\Models\OrderModel[] $orders */
            $orders = $this->parseDomToModel($dom);
        }

        return $orders;
    }

    /**
     * @inheritdoc
     */
    public function requestAjax(string $code, string $date): array
    {
        $date = date('n/j/Y', strtotime($date));
        $requestUrl = str_replace(['[CODE]', '[DATE]'], [$code, $date], $this->getUrlAjax());
        $response = $this->httpClient->request(
            'GET',
            $requestUrl, 
            [ 'verify' => false ]
        );

        $results = [];
        if ($response->getStatusCode() === 200) {
            $orders = json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
            if (!empty($orders) && \json_last_error() === JSON_ERROR_NONE) {
                if (isset($orders['Data']['DlChiTiet'])) {
                    $orders = $orders['Data']['DlChiTiet'];
                    $results = $this->factoryModel($orders);
                }
            }
        }

        return $results;
    }
    
    abstract public function parseDomToModel(HtmlDomParser $dom): array;

    abstract public function factoryModel(array $data): array;

    abstract public function getUrl(): string;

    abstract public function getUrlAjax(): string;
}