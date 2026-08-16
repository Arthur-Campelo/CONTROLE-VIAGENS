<?php

namespace App\Validation;

class DriverRules
{
    public function minimumAge(string $birthDate, string $params = '', array $data = [], ?string &$error = null): bool
    {
        try {
            $age = (new \DateTime($birthDate))->diff(new \DateTime())->y;
        } catch (\Exception $e) {
            $error = 'Data de nascimento inválida.';
            return false;
        }

        if ($age < 18) {
            $error = 'O motorista deve ter no mínimo 18 anos.';
            return false;
        }

        return true;
    }
}