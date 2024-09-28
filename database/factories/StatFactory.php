<?php

namespace Database\Factories;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stat>
 */
class StatFactory extends Factory
{
    protected $model = Stat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Normal', 'Urgente', 'Pendiente']), // Títulos de estados comunes
        ];
    }
}

