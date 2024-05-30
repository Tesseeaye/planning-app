<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Lists;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'content' => fake()->text(300),
            'lists_id' => Lists::factory(),
            'user_id' => User::factory(),
            'position' => fake()->unique()->randomNumber(),
        ];
    }
}
