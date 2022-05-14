<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        // TODO: create file on the disk (save a test image locally, and copy that)

        return [
            'filename' => 'image.png',
            'imageable_type' => Post::class,
            'imageable_id' => Post::query()->inRandomOrder()->first()->id,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Image $image) {
            //
        })->afterCreating(function (Image $image) {
            Storage::copy(
                'placeholders' . DIRECTORY_SEPARATOR . '1080x1080.png',
                'images' . DIRECTORY_SEPARATOR . $image->id . DIRECTORY_SEPARATOR . 'image.png',
            );
        });
    }


}
