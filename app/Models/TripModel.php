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
        // is_not_unique[vehicles.id] = "esse ID precisa existir na tabela vehicles".
        // Sem essa regra, um vehicle_id inválido só falhava lá na hora do INSERT,
        // com um erro cru de foreign key em vez de uma mensagem amigável no formulário.
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

    /**
     * NOVO: faltava esse método. O Controller original tentava fazer
     * `$this->tripModel->db->table(...)` para limpar os vínculos antigos
     * antes de regravar - só que `$db` é uma propriedade PROTECTED da
     * classe Model, inacessível de fora. Isso quebrava com erro fatal de
     * visibilidade toda vez que uma viagem era editada ou excluída.
     * Encapsulando aqui dentro do Model (onde $this->db É acessível)
     * resolve isso definitivamente.
     */
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

    /**
     * NOVO: confere se TODOS os IDs de motorista enviados pelo formulário
     * realmente existem na tabela drivers. Protege contra um motorista
     * excluído entre o momento em que o formulário foi carregado e o
     * momento em que foi enviado (senão o insertBatch() na tabela pivot
     * quebraria com um erro cru de foreign key).
     */
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

    /**
     * NOVO: antes só devolvia vehicle_id (número cru). Agora já traz o
     * modelo e a placa do veículo junto, pra listagem não mostrar um ID
     * sem contexto nenhum pro usuário.
     */
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