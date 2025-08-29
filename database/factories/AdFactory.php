<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'user_id' => fake()->numberBetween(1, 3),
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'file' => '',
            'file_type' => fake()->randomElement(['P', 'V']),
            'circulation' => fake()->numberBetween(500, 1000),
            'viewed' => fake()->numberBetween(0, 300),
            'cost' => fake()->numberBetween(1000, 100000),
            'commission' => 30,
            'gender' => fake()->optional()->randomElement(['male', 'female', 'other']),
            'operator_id' => fake()->optional()->numberBetween(1, 3),
            'min_age_id' => fake()->optional()->numberBetween(1, 3),
            'max_age_id' => fake()->optional()->numberBetween(9, 19),
            'status_id' => 4, //fake()->numberBetween(1, 5),
            'is_verify' => 1,
            'admin_id' => 1,
            'comment' => NULL,
            'start_date' => NULL, //fake()->optional()->date(),
            'end_date' => NULL, //fake()->optional()->date(),
        ];
    }
}
