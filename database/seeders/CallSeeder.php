<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Call;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Call::create([
            'user_id' => 1,
            'client_id' => 2,
            'stat_id' => 1,
            'user_id2' => 6,
            'callinf' =>'Activar office 2019',
            'clientname' =>'Materials de construcció Pepe',
            'clientphone' =>'977730043',
        ]);

        Call::create([
            'user_id' => 3,
            'client_id' => 3,
            'stat_id' => 2,
            'user_id2' => 6,
            'callinf' =>'Instal·lar client microgestio',
            'clientname' =>'Carburants BP',
            'clientphone' =>'977702262',
        ]);

        Call::create([
            'user_id' => 4,
            'client_id' => 1,
            'stat_id' => 3,
            'user_id2' => 6,
            'callinf' =>'Activar windows 10',
            'clientname' =>'Gestoria Paquita',
            'clientphone' =>'977480006 977489518 977489981',
        ]);

        Call::create([
            'user_id' => 2,
            'client_id' => 4,
            'stat_id' => 1,
            'user_id2' => 3,
            'callinf' =>'No pot connectar a internet',
            'clientname' =>'Optica Miranda',
            'clientphone' =>'977706942',
        ]);

        Call::create([
            'user_id' => 1,
            'client_id' => 2,
            'stat_id' => 2,
            'user_id2' => 6,
            'callinf' =>'No poden imprimir',
            'clientname' =>'Materials de construcció Pepe',
            'clientphone' =>'977730043 977705506',
        ]);

        Call::create([
            'user_id' => 2,
            'client_id' => 2,
            'stat_id' => 2,
            'user_id2' => 6,
            'callinf' =>'Revisar error microgestio',
            'clientname' =>'Materials de construcció Pepe',
            'clientphone' =>'977730043 977705506',
        ]);

        Call::create([
            'user_id' => 2,
            'client_id' => 3,
            'stat_id' => 2,
            'user_id2' => 6,
            'callinf' =>'No connecta microgestio client',
            'clientname' =>'Carburants BP',
            'clientphone' =>'977702262',
        ]);

        Call::create([
            'user_id' => 7,
            'client_id' => 1,
            'stat_id' => 2,
            'user_id2' => 6,
            'callinf' =>'Actualitzar Microgestio',
            'clientname' =>'Gestoria Paquita',
            'clientphone' =>'977480006 977489518 977489981',
        ]);

        Call::create([
            'user_id' => 3,
            'client_id' => 4,
            'stat_id' => 3,
            'user_id2' => 6,
            'callinf' =>'Revisar copia de seguretat',
            'clientname' =>'Optica Miranda',
            'clientphone' =>'977706942',
        ]);

        Call::create([
            'user_id' => 6,
            'client_id' => 2,
            'stat_id' => 3,
            'user_id2' => 2,
            'callinf' =>'Reparar taules microgestio',
            'clientname' =>'Materials de construcció Pepe',
            'clientphone' =>'977730043 977705506',
        ]);
    }
}

