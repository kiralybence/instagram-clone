<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\LikeRequest;
use App\Http\Requests\Api\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        private CommentService $commentService
    ) {
        //
    }

    /**
     * @param StoreRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function store(StoreRequest $request, Post $post): JsonResponse
    {
        // If parent_id was given
        $parent = $request->filled('parent_id')
            // then it's a reply
            ? Comment::query()->findOrFail($request->input('parent_id'))
            // otherwise it's a regular comment
            : $post;

        $comment = $this->commentService->storeComment($parent, $request->input('content'));

        return response()->json($comment);
    }

    /**
     * @param LikeRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function like(LikeRequest $request, Comment $comment): JsonResponse
    {
        $this->commentService->setLikeStatus($comment, $request->input('status'));

        return response()->json();
    }
}
