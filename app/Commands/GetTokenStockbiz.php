<?php

namespace App\Commands;

use App\Repository\TransactionRepository;
use App\Services\HistoryTransaction\AuthorizationStockbiz;
use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\CLI\CLI;
use Config\Services;

class GetTokenStockbiz extends BaseCmd
{
    const CACHE_TTL = 7 * 24 * 60 * 60;
    const TOKEN = 'TRANSACTION_TOKEN';
    protected $group       = 'GetTokenStockbiz';
    protected $name        = 'savetoken';
    protected $description = 'Get Token Stockbiz';

    /** @var AuthorizationStockbiz */
    private $authorization;
    /** @var CacheInterface */
    private $cache;

    public function __construct()
    {
        $this->authorization = new AuthorizationStockbiz();
        $this->cache = Services::cache();
    }

    public function run(array $params)
    {
        $token = $this->authorization->getToken();
        $this->cache->save(self::TOKEN, $token, self::CACHE_TTL);

        if ($this->cache->get(GetTokenStockbiz::TOKEN)) {
            CLI::write('DONE!');
        } else {
            CLI::write('FAIL!');
        }
    }
}