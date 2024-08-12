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
            'inittime' => now(),
            'endtime' => now(+60),
            'totalmin' => 60,
            'clientname' => 'Example Client'
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => 1,
            'job' => 'Configurar impresora',
            'inittime' => now(),
            'endtime' => now(+30),
            'totalmin' => 30,
            'clientname' => 'Another Client'
        ]);
    }
}

