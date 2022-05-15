<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\IndexRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function index(IndexRequest $request, Post $post)
    {
        $post->load([
            'user',
            'comments',
            'comments.user',
            'comments.replies',
            'comments.replies.user',
            'comments.parent',
            'comments.parent.user',
        ]);

        return Inertia::render('Comments/Index', [
            'post' => $post,
        ]);
    }
}
