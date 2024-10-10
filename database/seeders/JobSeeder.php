<?php

namespace Database\Seeders;

use App\Models\Client;
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
        $client1 = Client::find(1); // Recuperar el cliente con client_id = 1
        $client2 = Client::find(2);
        $client3 = Client::find(3);
        $client4 = Client::find(4);


        // Insertar trabajos específicos
        Job::create([
            'user_id' => 2,
            'client_id' => $client3->id,
            'job' => 'Activar office',
            'inittime' => now()->addMinutes(-60),
            'endtime' => now(),
            'totalmin' => 60,
            'clientname' => $client3->name,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => $client1->id,
            'job' => 'Configurar impresora',
            'inittime' => now()->addMinutes(-30),
            'endtime' => now(),
            'totalmin' => 30,
            'clientname' => $client1->name,
            'attempts' => 2,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => $client2->id,
            'job' => 'Revisar servidor de correo',
            'inittime' => now()->addMinutes(-20),
            'endtime' => now(),
            'totalmin' => 20,
            'clientname' => $client2->name,
        ]);

        Job::create([
            'user_id' => 2,
            'client_id' => $client4->id,
            'job' => 'Configurar red interna',
            'inittime' => now()->addMinutes(-40),
            'endtime' => now(),
            'totalmin' => 40,
            'clientname' => $client4->name,
            'attempts' => 3,
        ]);
    }
}

