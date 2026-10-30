<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTest extends Migration
{
    public function up(): void
    {
        // Membuat kolom/field untuk tabel news
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'author' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'John Doe',
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['published', 'draft'],
                'default'    => 'draft',
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Membuat primary key
        $this->forge->addKey('id', true);

        // Membuat tabel news
        $this->forge->createTable('test', true);
    }

    public function down(): void
    {
        //
    }
}
