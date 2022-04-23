<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
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
