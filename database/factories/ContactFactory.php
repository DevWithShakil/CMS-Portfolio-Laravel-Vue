<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'email'      => fake()->safeEmail(),
            'subject'    => fake()->sentence(4),
            'message'    => fake()->paragraph(2),
            'is_seen'    => fake()->boolean(30), // ৩০% মেসেজ seen দেখাবে
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
