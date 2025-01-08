<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableComments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_comment_parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'entity_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'entity_type' => [
                'type' => 'ENUM',
                'constraint' => ['item','collection'],
                'default' => 'item',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user', 'TableUser', 'id','CASCADE','RESTRICT');
        $this->forge->addForeignKey('id_comment_parent', 'comment', 'id','CASCADE','SET NULL');
        $this->forge->createTable('comment');
    }

    public function down()
    {
        $this->forge->dropTable('comment');
    }
}