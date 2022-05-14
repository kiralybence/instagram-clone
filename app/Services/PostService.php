<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(
        private ImageService $imageService
    ) {
        //
    }

    /**
     * Create a post.
     *
     * @param UploadedFile $image
     * @param string|null $caption
     * @return void
     */
    public function createPost(UploadedFile $image, ?string $caption): void
    {
        // TODO: refactor "description" to "caption" everywhere
        DB::transaction(function () use ($image, $caption) {
            $post = Post::query()->create([
                'description' => $caption,
                'user_id' => auth()->id(),
            ]);

            $post->image()->create([
                'filename' => $image->hashName(),
            ]);

            $image->storeAs('images' . DIRECTORY_SEPARATOR . $post->image->id, $post->image->filename);
            $this->imageService->compressImage($post->image);
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
