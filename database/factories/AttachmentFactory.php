<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_name' => fake()->uuid(),
            'file_type' => fake()->fileExtension(),
            'file_size' => fake()->randomNumber(),
            'alt_text' => fake()->sentence(),
            'card_id' => Card::factory(),
            'user_id' => User::factory(),
        ];
    }
}
