<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => $this->faker->words(rand(4, 12), true),
            'post_id' => Post::query()->inRandomOrder()->first()->id ?? Post::factory()->create()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
