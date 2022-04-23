<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    /**
     * Set the like status on a comment for the auth user.
     *
     * @param Comment $comment
     * @param bool $status
     * @return void
     */
    public function setLikeStatus(Comment $comment, bool $status): void
    {
        if ($status) {
            $comment->likedByUsers()->attach(auth()->id());
        } else {
            $comment->likedByUsers()->detach(auth()->id());
        }
    }
}
