<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Group extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('groups', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('groups', false);
    }
}
