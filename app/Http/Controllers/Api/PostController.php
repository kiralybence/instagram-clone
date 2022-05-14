<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\LikeRequest;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {
        //
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $this->postService->createPost($request->file('image'), $request->input('description'));

        return response()->json();
    }

    /**
     * @param LikeRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function like(LikeRequest $request, Post $post): JsonResponse
    {
        $this->postService->setLikeStatus($post, $request->input('status'));

        return response()->json();
    }
}
