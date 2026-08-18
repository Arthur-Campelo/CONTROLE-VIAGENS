<?php

namespace App\Models;

use CodeIgniter\Model;

class TripModel extends Model
{
    protected $table         = 'trips';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['vehicle_id', 'initial_km', 'final_km', 'start_datetime', 'end_datetime'];

    protected $validationRules = [
        'vehicle_id'     => 'required|integer|is_not_unique[vehicles.id]',
        'initial_km'     => 'required|integer',
        'final_km'       => 'required|integer|greater_than_equal_to[{initial_km}]',
        'start_datetime' => 'required|valid_date',
        'end_datetime'   => 'required|valid_date',
    ];

    protected $validationMessages = [
        'vehicle_id' => ['is_not_unique' => 'O veículo selecionado não existe (pode ter sido removido).'],
        'final_km'   => ['greater_than_equal_to' => 'O KM final deve ser maior ou igual ao KM inicial.'],
    ];

    public function attachDrivers(int $tripId, array $driverIds): void
    {
        $rows = array_map(
            static fn ($driverId) => ['trip_id' => $tripId, 'driver_id' => (int) $driverId],
            $driverIds
        );

        if ($rows !== []) {
            $this->db->table('trip_driver')->insertBatch($rows);
        }
    }

    public function detachDrivers(int $tripId): void
    {
        $this->db->table('trip_driver')->where('trip_id', $tripId)->delete();
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

    public function driversExist(array $driverIds): bool
    {
        if (empty($driverIds)) {
            return false;
        }

        $unique = array_unique(array_map('intval', $driverIds));

        $found = $this->db->table('drivers')
            ->whereIn('id', $unique)
            ->countAllResults();

        return $found === count($unique);
    }

    public function getTripsWithDetails(): array
    {
        $trips = $this->db->table('trips')
            ->select('trips.*, vehicles.model AS vehicle_model, vehicles.plate AS vehicle_plate')
            ->join('vehicles', 'vehicles.id = trips.vehicle_id')
            ->orderBy('trips.start_datetime', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($trips as &$trip) {
            $trip['drivers'] = $this->getDriversForTrip((int) $trip['id']);
        }

        return $trips;
    }
}