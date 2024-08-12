<?php

namespace Database\Factories;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Phone::class;
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->numberBetween(5, 44), // Genera un número aleatorio entre 5 y 44
            'phone' => $this->faker->numberBetween(111111111, 999999999), // Genera un número aleatorio entre 111111111 y 999999999
        ];
    }
}
