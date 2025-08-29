<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdLocation>
 */
class AdLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ad_id' => fake()->numberBetween(1, 15),
            'province_id' => 8,
            'city_id' => 330,
            'district_id' => NULL,
            'view' => 0
        ];
    }
}
