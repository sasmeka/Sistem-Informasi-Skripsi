<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'group_id' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'unsigned' => TRUE,
            ],
        ]);
        $this->forge->addKey(['user_id', 'group_id'], TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('group_id', 'groups', 'id', false, 'CASCADE');
        $this->forge->createTable('users_groups', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('users_groups', false);
    }
}
