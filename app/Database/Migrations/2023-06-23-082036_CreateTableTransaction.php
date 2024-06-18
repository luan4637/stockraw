<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTransaction extends Migration
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
            'date' => [
                'type'    => 'DATE',
            ],
            'vol' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'cur' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'open' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'high' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
            'low' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => FALSE,
                'default'    => 0.00
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['code']);
        $this->forge->addKey(['code', 'date'], false, false, 'code_date_key');
        $this->forge->createTable('transaction');
    }

    public function down()
    {
        $this->forge->dropTable('transaction');
    }
}
