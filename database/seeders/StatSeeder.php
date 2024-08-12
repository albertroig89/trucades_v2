<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat; // Asegúrate de que esta ruta sea correcta

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear instancias específicas de Stat
        Stat::create([
            'title' => 'Urgent',
        ]);

        Stat::create([
            'title' => 'Normal',
        ]);

        Stat::create([
            'title' => 'Pendent',
        ]);
    }
}

