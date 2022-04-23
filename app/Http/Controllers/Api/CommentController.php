<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\LikeRequest;
use App\Models\Comment;
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
     * @param LikeRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function like(LikeRequest $request, Comment $comment): JsonResponse
    {
        $this->commentService->setLikeStatus($comment, $request->status);

        return response()->json();
    }
}
