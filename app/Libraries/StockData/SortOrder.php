<?php

namespace App\Libraries\StockData;

use CodeIgniter\HTTP\IncomingRequest;

class SortOrder implements SortOrderInterface
{
    /** @var IncomingRequest */
    private $request;

    /**
     * @param 
     */
    public function __construct(IncomingRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritdoc
     */
    public function getSort(): string
    {
        return $this->request->getGet('sort') ?? '((vol / yesterday) * 100)';
    }

    /**
     * @inheritdoc
     */
    public function getOrder(): string
    {
        return $this->request->getGet('order') ?? 'desc';
    }
}