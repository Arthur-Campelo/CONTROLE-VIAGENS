<?php

namespace App\Models;

use CodeIgniter\Model;

class TripModel extends Model
{
    protected $table = 'trips';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['vehicle_id', 'initial_km', 'final_km', 'start_datetime', 'end_datetime'];

    protected $validationRules = [
        'vehicle_id' => 'required|integer',
        'initial_km' => 'required|integer',
        'final_km' => 'required|integer|greater_than_equal_to[{initial_km}]',
        'start_datetime' => 'required|valid_date',
        'end_datetime' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'final_km' => ['greater_than_equal_to' => 'O KM final não pode ser menor que o inicial!.'],
    ];

    /**
     * Gerencia o relacionamento N:N entre Trips e Drivers 
     * utilizando a tabela de junção 'trip_driver'.
     */
    public function attachDrivers(int $tripId, array $driverIds): void
    {
        $rows = array_map(
            static fn($driverId) => ['trip_id' => $tripId, 'driver_id' => (int) $driverId],
            $driverIds
        );

        if ($rows !== []) {
            $this->db->table('trip_driver')->insertBatch($rows);
        }
    }

    public function getDriversForTrip(int $tripId): array
    {
        return $this->db->table('drivers')
            ->select('drivers.*')
            ->join('trip_driver', 'trip_driver.driver_id = drivers.id')
            ->where('trip_driver.trip_id', $tripId)
            ->get()
            ->getResultArray();
    }

    public function getTripsWithDetails(): array
    {
        $trips = $this->findAll();

        foreach ($trips as &$trip) {
            $trip['drivers'] = $this->getDriversForTrip($trip['id']);
        }

        return $trips;
    }
}