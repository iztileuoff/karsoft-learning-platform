<?php

use App\Http\Controllers\Api\V1\Admin\AuthorController;
use App\Http\Controllers\Api\V1\Admin\DegreeController;
use App\Http\Controllers\Api\V1\Admin\InfoController;
use App\Http\Controllers\Api\V1\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('posts', PostController::class)->only('index');
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('infos', InfoController::class)->only('index', 'show', 'update');
    Route::apiResource('degrees', DegreeController::class)->only('index');
});
