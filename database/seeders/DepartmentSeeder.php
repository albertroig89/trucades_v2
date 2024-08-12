<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar departamentos específicos
        Department::create([
            'title' => 'Tecnic',
        ]);

        Department::create([
            'title' => 'Administracio',
        ]);

        Department::create([
            'title' => 'Programador',
        ]);

        Department::create([
            'title' => 'Comercial',
        ]);

        Department::create([
            'title' => 'Global',
        ]);
    }
}

