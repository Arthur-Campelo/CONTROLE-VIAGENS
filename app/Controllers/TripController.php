<?php

namespace App\Controllers;

use App\Models\TripModel;
use App\Models\VehicleModel;
use App\Models\DriverModel;

class TripController extends BaseController
{
    protected TripModel $tripModel;
    protected VehicleModel $vehicleModel;
    protected DriverModel $driverModel;

    public function __construct()
    {
        $this->tripModel    = new TripModel();
        $this->vehicleModel = new VehicleModel();
        $this->driverModel  = new DriverModel();
    }

    public function index()
    {
        return view('trips/index', ['trips' => $this->tripModel->getTripsWithDetails()]);
    }

    public function new()
    {
        return view('trips/form', [
            'trip'            => null,
            'vehicles'        => $this->vehicleModel->findAll(),
            'drivers'         => $this->driverModel->findAll(),
            'selectedDrivers' => [],
        ]);
    }

    public function create()
    {
        $post = $this->request->getPost();
        $data = [
            'vehicle_id'     => $post['vehicle_id'] ?? null,
            'initial_km'     => $post['initial_km'] ?? null,
            'final_km'       => $post['final_km'] ?? null,
            'start_datetime' => $post['start_datetime'] ?? null,
            'end_datetime'   => $post['end_datetime'] ?? null,
        ];

        // Regra: data/hora de chegada não pode ser antes da inicial
        if (strtotime((string) $data['end_datetime']) < strtotime((string) $data['start_datetime'])) {
            return redirect()->back()->withInput()
                ->with('errors', ['A data/hora de chegada não pode ser anterior à inicial.']);
        }

        $driverIds = array_map('intval', $post['driver_ids'] ?? []);

        if (empty($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Selecione ao menos um motorista.']);
        }

        // NOVO: antes, um driver_id inválido (ex.: motorista excluído entre
        // abrir o formulário e enviar) só ia quebrar depois, no insertBatch
        // da tabela pivot, com um erro cru de foreign key.
        if (! $this->tripModel->driversExist($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Um ou mais motoristas selecionados não existem mais. Atualize a página e tente de novo.']);
        }

        if (! $this->tripModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tripModel->errors());
        }

        $tripId = $this->tripModel->getInsertID();
        $this->tripModel->attachDrivers($tripId, $driverIds);

        return redirect()->to('/trips')->with('message', 'Viagem registrada com sucesso.');
    }

    public function edit($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/trips')->with('errors', ['ID inválido.']);
        }

        $trip = $this->tripModel->find($id);

        if ($trip === null) {
            return redirect()->to('/trips')->with('errors', ['Viagem não encontrada.']);
        }

        $selectedDrivers = array_column($this->tripModel->getDriversForTrip((int) $id), 'id');

        return view('trips/form', [
            'trip'            => $trip,
            'vehicles'        => $this->vehicleModel->findAll(),
            'drivers'         => $this->driverModel->findAll(),
            'selectedDrivers' => $selectedDrivers,
        ]);
    }

    public function update($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/trips')->with('errors', ['ID inválido.']);
        }

        if ($this->tripModel->find($id) === null) {
            return redirect()->to('/trips')->with('errors', ['Viagem não encontrada.']);
        }

        $post = $this->request->getPost();
        $data = [
            'id'             => $id,
            'vehicle_id'     => $post['vehicle_id'] ?? null,
            'initial_km'     => $post['initial_km'] ?? null,
            'final_km'       => $post['final_km'] ?? null,
            'start_datetime' => $post['start_datetime'] ?? null,
            'end_datetime'   => $post['end_datetime'] ?? null,
        ];

        if (strtotime((string) $data['end_datetime']) < strtotime((string) $data['start_datetime'])) {
            return redirect()->back()->withInput()
                ->with('errors', ['A data/hora de chegada não pode ser anterior à inicial.']);
        }

        $driverIds = array_map('intval', $post['driver_ids'] ?? []);

        if (empty($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Selecione ao menos um motorista.']);
        }

        if (! $this->tripModel->driversExist($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Um ou mais motoristas selecionados não existem mais. Atualize a página e tente de novo.']);
        }

        if (! $this->tripModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tripModel->errors());
        }

        // Remove os vínculos antigos e grava os novos (mais simples que fazer diff).
        // CORRIGIDO: chamando o método público do Model em vez de tentar
        // acessar a propriedade protected $db diretamente daqui de fora.
        $this->tripModel->detachDrivers((int) $id);
        $this->tripModel->attachDrivers((int) $id, $driverIds);

        return redirect()->to('/trips')->with('message', 'Viagem atualizada com sucesso.');
    }

    public function remove($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/trips')->with('errors', ['ID inválido.']);
        }

        $trip = $this->tripModel->find($id);

        // NOVO: mesmo padrão de proteção aplicado a Veículos e Motoristas.
        if ($trip === null) {
            return redirect()->to('/trips')->with('errors', ['Viagem não encontrada.']);
        }

        return view('trips/delete_confirm', ['trip' => $trip]);
    }

    public function delete($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/trips')->with('errors', ['ID inválido.']);
        }

        if ($this->tripModel->find($id) === null) {
            return redirect()->to('/trips')->with('errors', ['Viagem não encontrada.']);
        }

        // Viagem não é referenciada por nenhuma outra tabela (só referencia
        // vehicle e drivers), então não tem risco de violação de FK aqui -
        // mas o vínculo na tabela pivot precisa ser limpo manualmente.
        $this->tripModel->detachDrivers((int) $id);
        $this->tripModel->delete($id);

        return redirect()->to('/trips')->with('message', 'Viagem removida.');
    }
}