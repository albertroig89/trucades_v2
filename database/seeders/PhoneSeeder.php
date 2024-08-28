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
            'phone' => '977562234',
        ]);

        Phone::create([
            'client_id' => 1,
            'phone' => '977564798',
        ]);

        Phone::create([
            'client_id' => 1,
            'phone' => '977569874',
        ]);

        Phone::create([
            'client_id' => 2,
            'phone' => '977785564',
        ]);

        Phone::create([
            'client_id' => 2,
            'phone' => '977788565',
        ]);

        Phone::create([
            'client_id' => 3,
            'phone' => '977795864',
        ]);

        Phone::create([
            'client_id' => 4,
            'phone' => '977854664',
        ]);

        // Crear instancias de Phone usando el Factory
        Phone::factory(40)->create();
    }
}

