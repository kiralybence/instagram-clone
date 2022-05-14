<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * Create a post.
     *
     * @param UploadedFile $image
     * @param string $caption
     * @return void
     */
    public function createPost(UploadedFile $image, string $caption)
    {
        // TODO: use Intervention to compress image (to 1080px width) before saving

        // TODO: refactor "description" to "caption" everywhere
        DB::transaction(function () use ($image, $caption) {
            $post = Post::query()->create([
                'description' => $caption,
                'user_id' => auth()->id(),
            ]);

            $post->image()->create([
                'filename' => $image->hashName(),
            ]);

            // TODO: access images through ImageController::show() by its filename

            $image->storeAs('images' . DIRECTORY_SEPARATOR . $post->image->id, $image->hashName());
        });
    }

    /**
     * Set the like status on a post for the auth user.
     *
     * @param Post $post
     * @param bool $status
     * @return void
     */
    public function setLikeStatus(Post $post, bool $status): void
    {
        if ($status) {
            $post->likedByUsers()->attach(auth()->id());
        } else {
            $post->likedByUsers()->detach(auth()->id());
        }
    }
}
