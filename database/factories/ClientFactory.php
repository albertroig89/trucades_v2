<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Client $client) {
            // Genera entre 1 y 4 teléfonos por cliente
            $phonesCount = fake()->numberBetween(1, 4);
            Phone::factory()->count($phonesCount)->create([
                'client_id' => $client->id,
            ]);
        });
    }
}
