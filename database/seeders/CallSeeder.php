<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Call;
use App\Models\Client;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $clients = Client::all()->keyBy('id'); // Cargar todos los clientes y organizarlos por su id

        $calls = [
            [
                'user_id' => 1,
                'client_id' => 2,
                'stat_id' => 1,
                'user_id2' => 6,
                'callinf' => 'Revisar servidor web',
                'clientphone' => '666666666',
            ],
            [
                'user_id' => 3,
                'client_id' => 3,
                'stat_id' => 2,
                'user_id2' => 6,
                'callinf' => 'Preparar conexiones VPN',
            ],
            [
                'user_id' => 4,
                'client_id' => 1,
                'stat_id' => 3,
                'user_id2' => 6,
                'callinf' => 'Revisar copia de seguridad en la nube',
            ],
            [
                'user_id' => 2,
                'client_id' => 4,
                'stat_id' => 1,
                'user_id2' => 3,
                'callinf' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Cras convallis, elit at feugiat gravida, ex orci aliquam justo, vel viverra nunc orci a est. Proin sit amet fermentum velit. Curabitur at sollicitudin libero, vel tincidunt purus. Donec auctor justo ut ante malesuada, id bibendum justo dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed fermentum consequat turpis, at condimentum enim eleifend eu.
                Suspendisse potenti. Ut auctor fermentum libero, vitae cursus lorem pulvinar sit amet. Vivamus at urna nec risus lacinia condimentum non at sem. Donec viverra vehicula velit, sed auctor ex consectetur id. Nulla vestibulum purus ac sapien aliquet, at facilisis nisl dignissim. Nulla facilisi. Maecenas ut tincidunt justo. Aenean sit amet augue eget nulla bibendum posuere. Pellentesque accumsan urna a risus consectetur, in tristique tortor rhoncus. Integer sit amet mi id mi dapibus viverra non a magna.',
            ],
            [
                'user_id' => 1,
                'client_id' => 2,
                'stat_id' => 2,
                'user_id2' => 6,
                'callinf' => 'Revisar problemas de impresion de tickets',
            ],
            [
                'user_id' => 2,
                'client_id' => 2,
                'stat_id' => 3,
                'user_id2' => 6,
                'callinf' => 'Revisar problemas red interna',
            ],
            [
                'user_id' => 2,
                'client_id' => 3,
                'stat_id' => 2,
                'user_id2' => 6,
                'callinf' => 'Instalar antivirus nuevo en el servidor',
            ],
            [
                'user_id' => 7,
                'client_id' => 1,
                'stat_id' => 2,
                'user_id2' => 6,
                'callinf' => 'Interesados en software nuevo de gestion',
            ],
            [
                'user_id' => 3,
                'client_id' => 4,
                'stat_id' => 3,
                'user_id2' => 6,
                'callinf' => 'Revisar copia de seguretat',
            ],
            [
                'user_id' => 6,
                'client_id' => 2,
                'stat_id' => 3,
                'user_id2' => 2,
                'callinf' => 'Actualizar version de Wordpress',
            ],
        ];

        foreach ($calls as $callData) {
            $client = $clients->get($callData['client_id']);
            Call::create(array_merge($callData, [
                'clientname' => $client->name, // Asignar automáticamente el nombre del cliente
            ]));
        }
    }

}

