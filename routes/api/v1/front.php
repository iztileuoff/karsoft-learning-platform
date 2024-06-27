<?php

use App\Http\Controllers\Api\V1\Front\DistrictController;
use App\Http\Controllers\Api\V1\Front\PostController;
use App\Http\Controllers\Api\V1\Front\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('posts', PostController::class)->name('posts');
Route::get('districts', DistrictController::class)->name('districts');
Route::get('schools', SchoolController::class)->name('schools');

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('info', InfoController::class)->name('info');
    Route::apiSingleton('profile', ProfileController::class);

    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('textbooks', TextbookController::class)->only('index', 'show');
    Route::apiResource('quizzes', QuizController::class)->only('index', 'show');
});
