<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;
use App\Models\Client;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insertar clientes específicos
        $clients = [
            [
                'name' => "Gestoria Paquita",
                'email' => "info@gestoriapaquita.com",
            ],
            [
                'name' => "Materiales de construcción Pepe",
                'email' => "info@mcpepe.es",
            ],
            [
                'name' => "Carburantes BP",
                'email' => "info@carburantsbp.com",
            ],
            [
                'name' => "Optica Miranda",
                'email' => "info@opticamiranda.com",
            ],
        ];

        foreach ($clients as $clientData) {
            // Crear el cliente
            $client = Client::create($clientData);

            // Generar entre 1 y 4 números de teléfono aleatorios para cada cliente
            $phoneCount = rand(1, 4);
            for ($i = 0; $i < $phoneCount; $i++) {
                Phone::create([
                    'client_id' => $client->id,
                    'phone' => $faker->phoneNumber,
                ]);
            }
        }

        // Generar clientes ficticios
        Client::factory(60)->create();
    }
}

