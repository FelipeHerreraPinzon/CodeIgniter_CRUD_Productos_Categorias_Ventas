<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Producto extends Migration
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
            'nombre_producto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'categoria_producto' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'stock_producto' => [
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
        $this->forge->createTable('productos');
    }

    public function down()
    {
        $this->forge->dropTable('productos');
    }
}
