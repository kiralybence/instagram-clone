<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show(Request $request, Image $image)
    {
        // TODO: only allow viewing the image, if it belongs to a post that is accessible by the user

        return response()->file($image->getFilePath());
    }
}
