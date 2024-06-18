<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableStockData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'ref' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'top' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'bottom' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'cur' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'vol' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'createdAt' => [
                'type'    => 'DATE',
                'default' => '0000-00-00'
            ],
            'createdTime' => [
                'type'    => 'TIME',
                'default' => '00:00:00'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['createdAt']);
        $this->forge->createTable('stock_data');
    }

    public function down()
    {
        $this->forge->dropTable('stock_data');
    }
}
