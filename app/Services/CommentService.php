<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommentService
{
    /**
     * Store a comment under a post (or another comment).
     *
     * @param Post|Comment $parent
     * @param string $content
     * @return Builder|Model
     */
    public function storeComment(Post|Comment $parent, string $content): Model|Builder
    {
        $comment = Comment::query()->create([
            'content' => $content,
            'parent_id' => $parent instanceof Comment ? $parent->id : null,
            'post_id' => $parent instanceof Comment ? $parent->post_id : $parent->id,
            'user_id' => auth()->id(),
        ]);

        // TODO: make these relationships loaded by default (or create a CommentResource)
        $comment->load([
            'user',
            'replies',
            'replies.user',
            'parent',
            'parent.user',
        ]);

        return $comment;
    }

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
