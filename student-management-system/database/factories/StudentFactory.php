<?php

namespace Database\Factories;

use App\Models\Advisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'bio' => fake()->paragraph(),
            'date_of_birth' => fake()->date(),
            'advisor_id' => fake()->randomElement(Advisor::pluck('id')),
        ];
    }
}
