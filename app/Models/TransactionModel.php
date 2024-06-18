<?php
namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    const TABLE_NAME = 'transaction';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = ['code', 'date', 'vol', 'cur', 'open', 'high', 'low'];

    protected $useTimestamps = false;
}