<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::group([
        'controller' => PostController::class,
        'prefix' => 'posts',
        'as' => 'posts.',
    ], function () {
        Route::post('/', 'store')->name('store');
        Route::post('/{post}/like', 'like')->name('like');

        Route::group([
            'controller' => CommentController::class,
            'prefix' => '{post}/comments',
            'as' => 'comments.',
        ], function () {
            Route::post('/', 'store')->name('store');
        });
    });

    Route::group([
        'controller' => CommentController::class,
        'prefix' => 'comments',
        'as' => 'comments.',
    ], function () {
        Route::post('/{comment}/like', 'like')->name('like');
    });
});
