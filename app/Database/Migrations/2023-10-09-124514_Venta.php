<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Venta extends Migration
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
            'producto' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'cantidad' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ventas');
    }

    public function down()
    {
        $this->forge->dropTable('ventas');
    }
}
