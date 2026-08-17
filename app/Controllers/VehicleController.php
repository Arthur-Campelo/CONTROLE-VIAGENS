<?php

namespace App\Controllers;

use App\Models\VehicleModel;

class VehicleController extends BaseController
{
    protected VehicleModel $vehicleModel;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
    }

    public function index()
    {
        return view('vehicles/index', ['vehicles' => $this->vehicleModel->findAll()]);
    }

    public function new()
    {
        return view('vehicles/form', ['vehicle' => null]);
    }

    public function create()
    {
        $data = $this->request->getPost(['model', 'year', 'acquisition_date', 'acquisition_km', 'renavam', 'plate']);

        if (isset($data['acquisition_km']) && $data['acquisition_km'] !== '') {
            $data['acquisition_km'] = (int) $data['acquisition_km'];
        }

        if (!$this->vehicleModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->vehicleModel->errors());
        }

        return redirect()->to('/vehicles')->with('message', 'Veículo cadastrado com sucesso.');
    }

    public function edit($id = null)
    {
        $vehicle = $this->vehicleModel->find($id);

        if ($vehicle === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('vehicles/form', ['vehicle' => $vehicle]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost(['model', 'year', 'acquisition_date', 'acquisition_km', 'renavam', 'plate']);
        $data['id'] = $id;

        if (isset($data['acquisition_km']) && $data['acquisition_km'] !== '') {
            $data['acquisition_km'] = (int) $data['acquisition_km'];
        }

        if (!$this->vehicleModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->vehicleModel->errors());
        }

        return redirect()->to('/vehicles')->with('message', 'Veículo atualizado com sucesso.');
    }

    public function remove($id = null)
    {
        return view('vehicles/delete_confirm', ['vehicle' => $this->vehicleModel->find($id)]);
    }

    public function delete($id = null)
    {
        $this->vehicleModel->delete($id);
        return redirect()->to('/vehicles')->with('message', 'Veículo removido.');
    }
}