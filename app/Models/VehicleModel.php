<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicles';
    protected $id = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['model', 'year', 'acquisition_date', 'acquisition_km', 'renavam', 'plate'];

    protected $validationRules = [
        'model' => 'required|max_length[100]',
        'year' => 'required|integer',
        'acquisition_date' => 'required|valid_date',
        'acquisition_km' => 'required|integer',
        'renavam' => 'required|max_length[20]|is_unique[vehicles.renavam,id,{id}]',
        'plate' => 'required|max_length[10]|is_unique[vehicles.plate,id,{id}]',
    ];

    protected $validationMessages = [
        'renavam' => ['is_unique' => 'Este Renavam já está cadastrado.'],
        'plate' => ['is_unique' => 'Esta placa já está cadastrada.'],
    ];
}