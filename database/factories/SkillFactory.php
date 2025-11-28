<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->randomElement(['PHP', 'JavaScript', 'Python', 'Vue.js', 'React', 'Docker', 'AWS', 'Git', 'Figma']),
            'category'   => fake()->randomElement(['Frontend', 'Backend', 'DevOps', 'Tools', 'Design']),
            'percentage' => fake()->numberBetween(40, 98),
            'icon'       => null,
        ];
    }
}
