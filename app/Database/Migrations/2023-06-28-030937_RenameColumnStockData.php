<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameColumnStockData extends Migration
{
    public function up()
    {
        $fields = [
            'top' => [
                'name'       => 'high',
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'bottom' => [
                'name'       => 'low',
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
        ];
        $this->forge->modifyColumn('stock_data', $fields);
    }

    public function down()
    {
        $fields = [
            'high' => [
                'name'       => 'top',
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'low' => [
                'name'       => 'bottom',
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
        ];
        $this->forge->modifyColumn('stock_data', $fields);
    }
}
