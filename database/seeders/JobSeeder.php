<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar trabajos específicos
        Job::create([
            'user_id' => 2,
            'client_id' => 3,
            'job' => 'Activar office',
            'inittime' => now()->addMinutes(-60),
            'endtime' => now(),
            'totalmin' => 60,
            'clientname' => 'Example Client',
            'queue' => 'office',
            'payload' => 'Activar office',
            'attempts' => 0,
            'available_at' => 0,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => 1,
            'job' => 'Configurar impresora',
            'inittime' => now()->addMinutes(-30),
            'endtime' => now(),
            'totalmin' => 30,
            'clientname' => 'Another Client',
            'queue' => 'office',
            'payload' => 'Configurar impresora',
            'attempts' => 1,
            'available_at' => 1,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => 2,
            'job' => 'Revisar servidor de correo',
            'inittime' => now()->addMinutes(-20),
            'endtime' => now(),
            'totalmin' => 20,
            'clientname' => 'No ho acabo de pillar',
            'queue' => 'office',
            'payload' => 'Revisar servidor de correo',
            'attempts' => 0,
            'available_at' => 0,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => 4,
            'job' => 'Configurar red interna',
            'inittime' => now()->addMinutes(-40),
            'endtime' => now(),
            'totalmin' => 40,
            'clientname' => 'Perque tinc que especificar el nom del client',
            'queue' => 'office',
            'payload' => 'Configurar red interna',
            'attempts' => 1,
            'available_at' => 1,
        ]);
    }
}

