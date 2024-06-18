<?php

namespace App\Libraries\Order;

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
        return $this->request->getGet('sort') ?? 'volOrder';
    }

    /**
     * @inheritdoc
     */
    public function getOrder(): string
    {
        return $this->request->getGet('order') ?? 'desc';
    }
}