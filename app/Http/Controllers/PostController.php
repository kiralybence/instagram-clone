<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function create(CreateRequest $request)
    {
        return Inertia::render('Posts/Create');
    }
}
