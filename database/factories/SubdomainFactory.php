<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subdomain>
 */
class SubdomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
            'status' => $this->faker->numberBetween(0, 1),
            'op_teknis' => $this->faker->word(),
            'kontak_teknis' => $this->faker->phoneNumber(),
            'opd_pengelola' => $this->faker->numberBetween(1, 150),
            'keterangan' => $this->faker->text(20),
        ];
    }
}