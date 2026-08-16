<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        \CodeIgniter\Validation\StrictRules\Rules::class,
        \CodeIgniter\Validation\StrictRules\FormatRules::class,
        \CodeIgniter\Validation\StrictRules\FileRules::class,
        \CodeIgniter\Validation\StrictRules\CreditCardRules::class,
        \App\Validation\DriverRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
