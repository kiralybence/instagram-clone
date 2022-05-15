<?php

namespace App\Http\Controllers;

use App\Http\Requests\Home\IndexRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(IndexRequest $request)
    {
        return Inertia::render('Home', [
            'posts' => Post::query()->with(['image', 'user'])->latest()->get(),
        ]);
    }
}
