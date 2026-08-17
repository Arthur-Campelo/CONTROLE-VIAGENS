<?php

namespace App\Controllers;

use App\Models\DriverModel;

class DriverController extends BaseController
{
    protected DriverModel $driverModel;

    public function __construct()
    {
        $this->driverModel = new DriverModel();
    }

    public function index()
    {
        return view('drivers/index', ['drivers' => $this->driverModel->findAll()]);
    }

    public function new()
    {
        return view('drivers/form', ['driver' => null]);
    }

    public function create()
    {
        $data = $this->request->getPost(['name', 'birth_date', 'cnh_number']);

        if (!$this->driverModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->driverModel->errors());
        }

        return redirect()->to('/drivers')->with('message', 'Motorista cadastrado com sucesso.');
    }

    public function edit($id = null)
    {
        $driver = $this->driverModel->find($id);

        if ($driver === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('drivers/form', ['driver' => $driver]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost(['name', 'birth_date', 'cnh_number']);
        $data['id'] = $id;

        if (!$this->driverModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->driverModel->errors());
        }

        return redirect()->to('/drivers')->with('message', 'Motorista atualizado com sucesso.');
    }

    public function remove($id = null)
    {
        return view('drivers/delete_confirm', ['driver' => $this->driverModel->find($id)]);
    }

    public function delete($id = null)
    {
        $this->driverModel->delete($id);
        return redirect()->to('/drivers')->with('message', 'Motorista removido.');
    }
}