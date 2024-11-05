<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Genera valores de inicio y fin para el trabajo
        $inittime = Carbon::instance($this->faker->dateTimeBetween('-5 hours', 'now'));
        $endtime = Carbon::instance($this->faker->dateTimeBetween($inittime, 'now'));

        return [
            'user_id' => User::inRandomOrder()->first()->id, // Selecciona un usuario existente aleatoriamente
            'job' => $this->faker->sentence, // Información de la llamada
            'clientname' => $this->faker->name, // Nombre del cliente
            'inittime' => $inittime,
            'endtime' => $endtime,
            'totalmin' => $inittime->diffInMinutes($endtime), // Diferencia en minutos entre endtime e inittime
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
