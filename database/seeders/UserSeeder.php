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
        // Obtener ID's de los departamentos
        $techId = Department::where('title', 'Tecnico')->value('id');
        $progId = Department::where('title', 'Programador')->value('id');
        $admId = Department::where('title', 'Administración')->value('id');
        $comId = Department::where('title', 'Comercial')->value('id');
        $globId = Department::where('title', 'Global')->value('id');

        // Crear usuarios
        User::create([
            'name' => 'Global',
            'email' => 'global@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $globId,
            'avatar' => 'images/global.png',
        ]);

        User::create([
            'name' => 'Albert Roig',
            'email' => 'albert@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $techId,
            'avatar' => 'images/albert.jpg',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Victor Fuentes',
            'email' => 'sat@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $techId,
            'avatar' => 'assets/img/team-2.jpg',
        ]);

        User::create([
            'name' => 'Antonio Ferrer',
            'email' => 'antonio@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $techId,
            'avatar' => 'assets/img/bruce-mars.jpg',
        ]);

        User::create([
            'name' => 'Julio Ceballos',
            'email' => 'julio@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $techId,
            'avatar' => 'assets/img/ivana-square.jpg',
        ]);

        User::create([
            'name' => 'Teresa Alcántara',
            'email' => 'administracion@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $admId,
            'avatar' => 'assets/img/team-5.jpg',
        ]);

        User::create([
            'name' => 'David Cantero',
            'email' => 'comercial@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $comId,
            'avatar' => 'assets/img/team-4.jpg',
        ]);

        User::create([
            'name' => 'Alejandro Garcia',
            'email' => 'soft@email.com',
            'password' => bcrypt('12345678'),
            'department_id' => $progId,
            'avatar' => 'assets/img/team-1.jpg',
        ]);
    }
}

