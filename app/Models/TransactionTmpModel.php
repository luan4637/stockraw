<?php
namespace App\Models;

use CodeIgniter\Model;

class TransactionTmpModel extends Model
{
    const TABLE_NAME = 'transaction_view';
    protected $table = 'transaction_tmp';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = ['code', 'yesterday', 'twoDayAgo', 'threeDayAgo'];

    protected $useTimestamps = false;
}