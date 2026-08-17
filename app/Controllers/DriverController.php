<?php

namespace App\Controllers;

use App\Models\DriverModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

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

        if (! $this->driverModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->driverModel->errors());
        }

        return redirect()->to('/drivers')->with('message', 'Motorista cadastrado com sucesso.');
    }

    public function edit($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/drivers')->with('errors', ['ID inválido.']);
        }

        $driver = $this->driverModel->find($id);

        if ($driver === null) {
            return redirect()->to('/drivers')->with('errors', ['Motorista não encontrado.']);
        }

        return view('drivers/form', ['driver' => $driver]);
    }

    public function update($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/drivers')->with('errors', ['ID inválido.']);
        }

        if ($this->driverModel->find($id) === null) {
            return redirect()->to('/drivers')->with('errors', ['Motorista não encontrado.']);
        }

        $data = $this->request->getPost(['name', 'birth_date', 'cnh_number']);
        $data['id'] = $id;

        if (! $this->driverModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->driverModel->errors());
        }

        return redirect()->to('/drivers')->with('message', 'Motorista atualizado com sucesso.');
    }

    public function remove($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/drivers')->with('errors', ['ID inválido.']);
        }

        $driver = $this->driverModel->find($id);

        // NOVO: mesmo problema do VehicleController - ID inexistente
        // quebrava a view antes.
        if ($driver === null) {
            return redirect()->to('/drivers')->with('errors', ['Motorista não encontrado.']);
        }

        return view('drivers/delete_confirm', ['driver' => $driver]);
    }

    public function delete($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/drivers')->with('errors', ['ID inválido.']);
        }

        if ($this->driverModel->find($id) === null) {
            return redirect()->to('/drivers')->with('errors', ['Motorista não encontrado.']);
        }

        // NOVO: motorista vinculado a alguma viagem (tabela trip_driver)
        // não pode ser excluído por causa da foreign key RESTRICT.
        try {
            $this->driverModel->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to('/drivers')
                ->with('errors', ['Não é possível excluir este motorista: ele está vinculado a alguma viagem.']);
        }

        return redirect()->to('/drivers')->with('message', 'Motorista removido.');
    }
}