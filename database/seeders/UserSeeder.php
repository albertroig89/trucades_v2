<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department; // Asegúrate de que esta ruta sea correcta

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener IDs de los departamentos
        $techId = Department::where('title', 'Tecnic')->value('id');
        $progId = Department::where('title', 'Programador')->value('id');
        $admId = Department::where('title', 'Administracio')->value('id');
        $comId = Department::where('title', 'Comercial')->value('id');
        $globId = Department::where('title', 'Global')->value('id');

        // Crear usuarios
        User::create([
            'name' => 'Global',
            'email' => 'global@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $globId,
        ]);

        User::create([
            'name' => 'Albert Roig',
            'email' => 'albert@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $techId,
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Jordi Espinoso',
            'email' => 'sat@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $techId,
        ]);

        User::create([
            'name' => 'Joel Galindo',
            'email' => 'joel@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $techId,
        ]);

        User::create([
            'name' => 'Josep Costelles',
            'email' => 'josep@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $techId,
        ]);

        User::create([
            'name' => 'Cristina Dretera',
            'email' => 'administracio@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $admId,
        ]);

        User::create([
            'name' => 'Manel Pel',
            'email' => 'comercial@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $comId,
        ]);

        User::create([
            'name' => 'Juan Galindo',
            'email' => 'soft@microdelta.net',
            'password' => bcrypt('MicAmposta43'),
            'department_id' => $progId,
        ]);
    }
}

