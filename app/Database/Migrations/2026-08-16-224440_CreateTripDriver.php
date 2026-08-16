<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTripDriver extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'trip_id'   => ['type' => 'INT', 'unsigned' => true],
            'driver_id' => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey(['trip_id', 'driver_id']);
        $this->forge->addForeignKey('trip_id', 'trips', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('driver_id', 'drivers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('trip_driver');
    }

    public function down()
    {
        $this->forge->dropTable('trip_driver');
    }
}