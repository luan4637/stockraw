<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCodes extends Migration
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
            'groupId' => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'exchange' => [
                'type'       => 'VARCHAR',
                'constraint' => 8,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'unique'     => true,
            ],
            'des' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'active' => [
                'type' => 'BOOL',
                'default' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('codes');
    }

    public function down()
    {
        $this->forge->dropTable('codes');
    }
}
