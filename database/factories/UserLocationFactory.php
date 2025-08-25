<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserLocation>
 */
class UserLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => '1',
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'province_id' => fake()->numberBetween(1, 31),
            'city_id' => fake()->numberBetween(1, 1353),
            'district_id' => fake()->optional()->numberBetween(1, 353),
        ];
    }
}
