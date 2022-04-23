<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function index(Request $request, Post $post)
    {
        $post->load(['user', 'comments', 'comments.user']);

        return Inertia::render('Comments/Index', [
            'post' => $post,
        ]);
    }
}
