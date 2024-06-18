<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;

abstract class BaseCmd extends BaseCommand
{
    public function __construct()
    {
        require FCPATH . '../app/Helpers/DateFormat_helper.php';
    }
}