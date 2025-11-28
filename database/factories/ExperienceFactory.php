<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'position'    => fake()->jobTitle(),
            'company'     => fake()->company(),
            'duration'    => fake()->year() . ' - ' . 'Present',
            'description' => fake()->paragraph(2),
        ];
    }
}
