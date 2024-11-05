<?php

namespace Database\Factories;

use App\Models\Call;
use App\Models\User;
use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class CallFactory extends Factory
{
    protected $model = Call::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Selecciona un usuario existente aleatoriamente
            'user_id2' => User::inRandomOrder()->first()->id, // Otro usuario existente aleatorio, si aplica
            'stat_id' => Stat::inRandomOrder()->first()->id, // Relaciona con un estado ya existente
            'callinf' => $this->faker->sentence, // Información de la llamada
            'clientname' => $this->faker->name, // Nombre del cliente
            'clientphone' => $this->faker->phoneNumber, // Teléfono del cliente
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}


