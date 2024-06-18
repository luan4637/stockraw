<?php

namespace App\Services\Exchange;

class ExchangeVps extends AbstractRequest implements ExchangeInterface
{
    const URL  = 'https://bgapidatafeed.vps.com.vn/getliststockdata/';

    public function __construct()
    {
        parent::__construct(
            new \GuzzleHttp\Client(),
            new \PHPHtmlParser\Dom()
        );
    }

    /**
     * @return array
     */
    public function getFormatResponse(): array
    {
        return [
            'code' => 'sym',
            'ref' => 'r',
            'high' => 'c',
            'low' => 'f',
            'cur' => 'lastPrice',
            'vol' => 'lot'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return self::URL;
    }
}