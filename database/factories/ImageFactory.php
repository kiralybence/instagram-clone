<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // TODO: create file on the disk (maybe even download image from https://via.placeholder.com/800x800)

        return [
            'filename' => 'image.jpg',
            'imageable_type' => Post::class,
            'imageable_id' => Post::query()->inRandomOrder()->first()->id,
        ];
    }
}
