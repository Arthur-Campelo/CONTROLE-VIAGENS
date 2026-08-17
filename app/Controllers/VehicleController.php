<?php

namespace App\Controllers;

use App\Models\VehicleModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

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

        if (! $this->vehicleModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->vehicleModel->errors());
        }

        return redirect()->to('/vehicles')->with('message', 'Veículo cadastrado com sucesso.');
    }

    public function edit($id = null)
    {
        // NOVO: um :id não-numérico (ex.: /vehicles/edit/abc) ia direto pro
        // find(), e o Postgres rejeita comparar uma coluna INT com uma
        // string não-numérica - resultava numa exceção de banco não
        // tratada. Bloqueando aqui antes de tocar no banco.
        if (! is_numeric($id)) {
            return redirect()->to('/vehicles')->with('errors', ['ID inválido.']);
        }

        $vehicle = $this->vehicleModel->find($id);

        // NOVO: antes só o edit() checava isso. Padronizado em todos os
        // métodos que recebem um :id vindo da URL.
        if ($vehicle === null) {
            return redirect()->to('/vehicles')->with('errors', ['Veículo não encontrado.']);
        }

        return view('vehicles/form', ['vehicle' => $vehicle]);
    }

    public function update($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/vehicles')->with('errors', ['ID inválido.']);
        }

        if ($this->vehicleModel->find($id) === null) {
            return redirect()->to('/vehicles')->with('errors', ['Veículo não encontrado.']);
        }

        $data = $this->request->getPost(['model', 'year', 'acquisition_date', 'acquisition_km', 'renavam', 'plate']);
        $data['id'] = $id;

        if (! $this->vehicleModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->vehicleModel->errors());
        }

        return redirect()->to('/vehicles')->with('message', 'Veículo atualizado com sucesso.');
    }

    public function remove($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/vehicles')->with('errors', ['ID inválido.']);
        }

        $vehicle = $this->vehicleModel->find($id);

        // NOVO: antes, um ID inexistente chegava direto na view e quebrava
        // ao tentar ler $vehicle['model'] de um null.
        if ($vehicle === null) {
            return redirect()->to('/vehicles')->with('errors', ['Veículo não encontrado.']);
        }

        return view('vehicles/delete_confirm', ['vehicle' => $vehicle]);
    }

    public function delete($id = null)
    {
        if (! is_numeric($id)) {
            return redirect()->to('/vehicles')->with('errors', ['ID inválido.']);
        }

        if ($this->vehicleModel->find($id) === null) {
            return redirect()->to('/vehicles')->with('errors', ['Veículo não encontrado.']);
        }

        // NOVO: se o veículo estiver vinculado a alguma viagem, o banco
        // recusa o DELETE por causa da foreign key (RESTRICT) da tabela
        // trips. Antes isso derrubava a aplicação com uma tela de erro
        // crua; agora vira uma mensagem amigável.
        try {
            $this->vehicleModel->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to('/vehicles')
                ->with('errors', ['Não é possível excluir este veículo: existem viagens vinculadas a ele.']);
        }

        return redirect()->to('/vehicles')->with('message', 'Veículo removido.');
    }
}