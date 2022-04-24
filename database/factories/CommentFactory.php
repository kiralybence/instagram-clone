<?php

namespace Database\Factories;

use App\Models\Comment;
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
            'parent_id' => NULL,
            'post_id' => Post::query()->inRandomOrder()->first()->id ?? Post::factory()->create()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }

    public function withReplies()
    {
        return $this->afterCreating(function (Comment $comment) {
            Comment::factory()->count(rand(1, 3))->create([
                'parent_id' => $comment->id,
                'post_id' => $comment->post_id,
            ]);
        });
    }
}
