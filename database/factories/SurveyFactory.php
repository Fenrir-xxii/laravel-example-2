<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(500),
            'description' => fake()->text(2000),
            'search' => null,
            'start_at' => now(),
            'end_at' => now()->addDays(3),
            'active' => true,
        ];
    }
}
