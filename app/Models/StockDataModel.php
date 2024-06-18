<?php
namespace App\Models;

use CodeIgniter\Model;

class StockDataModel extends Model
{
    const TABLE_NAME = 'stock_data';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = ['code', 'ref', 'high', 'low', 'cur', 'vol', 'createdAt', 'createdTime'];

    protected $useTimestamps = false;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table;
    }
}