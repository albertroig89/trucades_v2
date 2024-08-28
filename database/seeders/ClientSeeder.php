<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar clientes específicos
        Client::create([
            'name' => "Gestoria Paquita",
            'email' => "info@gestoriapaquita.com",
        ]);

        Client::create([
            'name' => "Materiales de construcción Pepe",
            'email' => "info@mcpepe.es",
        ]);

        Client::create([
            'name' => "Carburantes BP",
            'email' => "info@carburantsbp.com",
        ]);

        Client::create([
            'name' => "Optica Miranda",
            'email' => "info@opticamiranda.com",
        ]);

        // Generar clientes ficticios
        Client::factory(40)->create();
    }
}

