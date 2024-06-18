<?php

namespace App\Services\HistoryTransaction;

use GuzzleHttp\Client;

class AuthorizationStockbiz
{
    const URL = 'https://stockbiz.vn';

    /** @var Client $httpClient */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getToken()
    {
        $token = '';
        $response = $this->httpClient->request(
            'GET',
            self::URL,
            [
                'verify' => false,
            ]
        );
        if ($response->getStatusCode() === 200) {
            /** @var string $contentHtml */
            $contentHtml = (string) $response->getBody();

            if (preg_match('/"accessToken":"(.*?)"/', $contentHtml, $match) == 1) {
                $token = $match[1];
            }
        }

        return $token;
    }
}