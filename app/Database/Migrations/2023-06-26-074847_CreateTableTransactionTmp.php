<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTransactionTmp extends Migration
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
            'yesterday' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'twoDayAgo' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'threeDayAgo' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaction_tmp');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_tmp');
    }
}
