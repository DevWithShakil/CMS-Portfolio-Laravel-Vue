<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    public function definition(): array
    {
        return [

            'category_id' => BlogCategory::inRandomOrder()->first()->id ?? BlogCategory::factory(),
            'title' => fake()->sentence(6),
            'slug' => fake()->slug(),
            'content' => fake()->paragraphs(5, true),
            'thumbnail' => null,
            'is_published' => fake()->boolean(80),
        ];
    }
}
