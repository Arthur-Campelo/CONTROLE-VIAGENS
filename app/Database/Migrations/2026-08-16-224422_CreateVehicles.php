<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVehicles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'model'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'year'             => ['type' => 'INT'],
            'acquisition_date' => ['type' => 'DATE'],
            'acquisition_km'   => ['type' => 'INT'],
            'renavam'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'plate'            => ['type' => 'VARCHAR', 'constraint' => 10],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('renavam');
        $this->forge->addUniqueKey('plate');
        $this->forge->createTable('vehicles');
    }

    public function down()
    {
        $this->forge->dropTable('vehicles');
    }
}