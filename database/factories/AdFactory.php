<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Operator;
use App\Models\Status;
use App\Models\User;
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
            'user_id' => User::factory(), // یا $this->faker->numberBetween(1, 10) اگر factory آماده نیست
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'file' => $this->faker->filePath(), // یا یک string فیک مثل 'path/to/file.jpg'
            'file_type' => $this->faker->randomElement(['P', 'V']),
            'circulation' => $this->faker->numberBetween(100, 10000),
            'viewed' => $this->faker->numberBetween(0, 5000),
            'cost' => $this->faker->numberBetween(1000, 100000),
            'commission' => $this->faker->optional()->numberBetween(100, 5000),
            'gender' => $this->faker->optional()->randomElement(['male', 'female', 'other']),
            'operator_id' => $this->faker->optional()->randomElement(Operator::factory()),
            'min_age_id' => $this->faker->optional()->randomElement(Age::factory()),
            'max_age_id' => $this->faker->optional()->randomElement(Age::factory()),
            'status_id' => Status::factory(),
            'is_verify' => $this->faker->boolean(),
            'admin_id' => $this->faker->optional()->randomElement(Admin::factory()),
            'comment' => $this->faker->optional()->paragraph(),
            'start_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
        ];
    }
}
