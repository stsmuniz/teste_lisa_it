<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InfluencerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'instagram_username' => fake()->userName(),
            'followers_qty' => fake()->numberBetween(1000, 1000000),
            'category' => fake()->randomElement(['lifestyle', 'fashion', 'technology', 'food', 'travel']),
        ];
    }
}
