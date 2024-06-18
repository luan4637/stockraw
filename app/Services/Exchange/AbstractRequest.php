<?php

namespace App\Services\Exchange;

use App\Repository\StockDataRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

abstract class AbstractRequest implements AbstractRequestInterface
{
    const MIN_VOLUME_VALID = 10000;
    /** @var Client $httpClient */
    private $httpClient;
    /** @var StockDataRepository */
    private $stockDataRepository;

    /**
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->stockDataRepository = new StockDataRepository();
    }

    /**
     * @inheritdoc
     */
    public function request(array $codes)
    {
        $volumnPerStock = 10;
        $createdAt = date('Y-m-d');
        $createdTime = date('H:i:s');
        $formatResponse = $this->getFormatResponse();
        $listCodes = array_chunk($codes, 50);
        $promises = [];
        foreach ($listCodes as $listCode) {
            $requestUrl = $this->getUrl() . implode(',', $listCode);
            $promises[] = $this->httpClient->request(
                'GET',
                $requestUrl, 
                [ 'verify' => false ]
            );
        }
        $results = Utils::settle($promises)->wait();

        foreach ($results as $result) {
            if (isset($result['value'])) {
                $response = $result['value'];
                if ($response->getStatusCode() === 200) {
                    $dataStocks = json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
                    if (!empty($dataStocks) && \json_last_error() === JSON_ERROR_NONE) {
                        foreach ($dataStocks as $item) {
                            $this->stockDataRepository->save([
                                'code' => $item[$formatResponse['code']],
                                'ref' => $item[$formatResponse['ref']],
                                'high' => $item[$formatResponse['high']],
                                'low' => $item[$formatResponse['low']],
                                'cur' => $item[$formatResponse['cur']],
                                'vol' => str_replace('.', '', $item[$formatResponse['vol']]) * $volumnPerStock,
                                'createdAt' => $createdAt,
                                'createdTime' => $createdTime
                            ]);
                        }
                    }
                }
            }
        }
    }

    abstract public function getFormatResponse();
    abstract public function getUrl(): string;
}