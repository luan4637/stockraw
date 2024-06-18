<?php
namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    const TABLE_NAME = 'codes';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = ['groupId', 'exchange', 'name', 'des', 'active'];

    protected $useTimestamps = false;
}