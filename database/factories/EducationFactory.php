<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'degree'      => fake()->randomElement(['BSc in Computer Science', 'MSc in Software Engineering', 'Diploma in Web Dev']),
            'institution' => fake()->company() . ' University',
            'duration'    => fake()->numberBetween(2015, 2019) . ' - ' . fake()->numberBetween(2020, 2024),
            'description' => fake()->sentence(10),
        ];
    }
}
