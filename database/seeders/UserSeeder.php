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
            'email' => 'global@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $globId,
        ]);

        User::create([
            'name' => 'Albert Roig',
            'email' => 'albert@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $techId,
            'avatar' => 'images/albert.jpg',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Jordi Espinoso',
            'email' => 'sat@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $techId,
            'avatar' => 'assets/img/team-2.jpg',
        ]);

        User::create([
            'name' => 'Joel Galindo',
            'email' => 'joel@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $techId,
            'avatar' => 'assets/img/bruce-mars.jpg',
        ]);

        User::create([
            'name' => 'Josep Costelles',
            'email' => 'josep@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $techId,
            'avatar' => 'assets/img/ivana-square.jpg',
        ]);

        User::create([
            'name' => 'Cristina Dretera',
            'email' => 'administracio@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $admId,
            'avatar' => 'assets/img/team-5.jpg',
        ]);

        User::create([
            'name' => 'Manel Pel',
            'email' => 'comercial@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $comId,
            'avatar' => 'assets/img/team-4.jpg',
        ]);

        User::create([
            'name' => 'Juan Galindo',
            'email' => 'soft@gmail.com',
            'password' => bcrypt('123456'),
            'department_id' => $progId,
            'avatar' => 'assets/img/team-1.jpg',
        ]);
    }
}

