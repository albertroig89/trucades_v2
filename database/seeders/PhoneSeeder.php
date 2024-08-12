<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone; // Asegúrate de que esta ruta sea correcta

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear instancias específicas de Phone
        Phone::create([
            'client_id' => 1,
            'phone' => '977480006',
        ]);

        Phone::create([
            'client_id' => 1,
            'phone' => '977489518',
        ]);

        Phone::create([
            'client_id' => 1,
            'phone' => '977489981',
        ]);

        Phone::create([
            'client_id' => 2,
            'phone' => '977730043',
        ]);

        Phone::create([
            'client_id' => 2,
            'phone' => '977705506',
        ]);

        Phone::create([
            'client_id' => 3,
            'phone' => '977702262',
        ]);

        Phone::create([
            'client_id' => 4,
            'phone' => '977706942',
        ]);

        // Crear instancias de Phone usando el Factory
        Phone::factory(40)->create();
    }
}

