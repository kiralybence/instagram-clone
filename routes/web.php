<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // TODO: fix API key issue, and move these to api.php
    Route::group([
        'prefix' => 'api',
        'as' => 'api.',
    ], function () {
        Route::group([
            'controller' => PostController::class,
            'prefix' => 'posts',
            'as' => 'posts.',
        ], function () {
            Route::post('/{post}/like', 'like')->name('like');
        });
    });

    Route::get('/', [HomeController::class, 'index'])->name('home');
});
