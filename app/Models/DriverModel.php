<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverModel extends Model
{
    protected $table = 'drivers';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'birth_date', 'cnh_number'];

    protected $validationRules = [
        'name' => 'required|max_length[150]',
        'birth_date' => 'required|valid_date|minimumAge',
        'cnh_number' => 'required|max_length[20]',
    ];

    protected $validationMessages = [
        'birth_date' => ['minimumAge' => 'O motorista deve ter no mínimo 18 anos.'],
    ];
}