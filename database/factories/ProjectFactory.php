<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'description' => fake()->paragraph(3),
            'tech_stack' => fake()->randomElement(['Laravel, Vue', 'React, Node', 'Python, Django', 'PHP, MySQL']),
            'thumbnail' => null,
            'github_link' => 'https://github.com',
            'live_link' => 'https://google.com',
        ];
    }
}
