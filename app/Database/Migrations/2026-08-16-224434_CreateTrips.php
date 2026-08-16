<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrips extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'vehicle_id'     => ['type' => 'INT', 'unsigned' => true],
            'initial_km'     => ['type' => 'INT'],
            'final_km'       => ['type' => 'INT'],
            'start_datetime' => ['type' => 'DATETIME'],
            'end_datetime'   => ['type' => 'DATETIME'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('vehicle_id', 'vehicles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('trips');
    }

    public function down()
    {
        $this->forge->dropTable('trips');
    }
}