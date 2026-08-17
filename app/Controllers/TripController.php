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
        $this->tripModel = new TripModel();
        $this->vehicleModel = new VehicleModel();
        $this->driverModel = new DriverModel();
    }

    public function index()
    {
        return view('trips/index', ['trips' => $this->tripModel->getTripsWithDetails()]);
    }

    public function new()
    {
        return view('trips/form', [
            'trip' => null,
            'vehicles' => $this->vehicleModel->findAll(),
            'drivers' => $this->driverModel->findAll(),
            'selectedDrivers' => [],
        ]);
    }

    public function create()
    {
        $post = $this->request->getPost();
        $data = [
            'vehicle_id' => $post['vehicle_id'],
            'initial_km' => $post['initial_km'],
            'final_km' => $post['final_km'],
            'start_datetime' => $post['start_datetime'],
            'end_datetime' => $post['end_datetime'],
        ];

        // Regra: data/hora de chegada não pode ser antes da inicial
        if (strtotime($data['end_datetime']) < strtotime($data['start_datetime'])) {
            return redirect()->back()->withInput()
                ->with('errors', ['end_datetime' => 'A data/hora de chegada não pode ser anterior à inicial.']);
        }

        // Regra: pelo menos um motorista selecionado
        $driverIds = $post['driver_ids'] ?? [];
        if (empty($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['driver_ids' => 'Selecione ao menos um motorista.']);
        }

        if (!$this->tripModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tripModel->errors());
        }

        $tripId = $this->tripModel->getInsertID();
        $this->tripModel->attachDrivers($tripId, $driverIds);

        return redirect()->to('/trips')->with('message', 'Viagem registrada com sucesso.');
    }

    public function edit($id = null)
    {
        $trip = $this->tripModel->find($id);

        if ($trip === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $selectedDrivers = array_column($this->tripModel->getDriversForTrip($id), 'id');

        return view('trips/form', [
            'trip' => $trip,
            'vehicles' => $this->vehicleModel->findAll(),
            'drivers' => $this->driverModel->findAll(),
            'selectedDrivers' => $selectedDrivers,
        ]);
    }

    public function update($id = null)
    {
        $post = $this->request->getPost();
        $data = [
            'id' => $id,
            'vehicle_id' => $post['vehicle_id'],
            'initial_km' => $post['initial_km'],
            'final_km' => $post['final_km'],
            'start_datetime' => $post['start_datetime'],
            'end_datetime' => $post['end_datetime'],
        ];

        if (strtotime($data['end_datetime']) < strtotime($data['start_datetime'])) {
            return redirect()->back()->withInput()
                ->with('errors', ['end_datetime' => 'A data/hora de chegada não pode ser anterior à inicial.']);
        }

        $driverIds = $post['driver_ids'] ?? [];
        if (empty($driverIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['driver_ids' => 'Selecione ao menos um motorista.']);
        }

        if (!$this->tripModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->tripModel->errors());
        }

        // Remove os vínculos antigos e grava os novos (mais simples que fazer diff)
        $this->tripModel->db->table('trip_driver')->where('trip_id', $id)->delete();
        $this->tripModel->attachDrivers((int) $id, $driverIds);

        return redirect()->to('/trips')->with('message', 'Viagem atualizada com sucesso.');
    }

    public function remove($id = null)
    {
        return view('trips/delete_confirm', ['trip' => $this->tripModel->find($id)]);
    }

    public function delete($id = null)
    {
        $this->tripModel->delete($id);
        return redirect()->to('/trips')->with('message', 'Viagem removida.');
    }
}