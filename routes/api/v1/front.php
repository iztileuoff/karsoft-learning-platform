<?php

use App\Http\Controllers\Api\V1\Front\AuthorController;
use App\Http\Controllers\Api\V1\Front\DistrictController;
use App\Http\Controllers\Api\V1\Front\InfoController;
use App\Http\Controllers\Api\V1\Front\LessonController;
use App\Http\Controllers\Api\V1\Front\PostController;
use App\Http\Controllers\Api\V1\Front\ProfileController;
use App\Http\Controllers\Api\V1\Front\QuizController;
use App\Http\Controllers\Api\V1\Front\SchoolController;
use App\Http\Controllers\Api\V1\Front\TestController;
use App\Http\Controllers\Api\V1\Front\TextbookController;
use Illuminate\Support\Facades\Route;

Route::get('posts', PostController::class)->name('posts');
Route::get('districts', DistrictController::class)->name('districts');
Route::get('schools', SchoolController::class)->name('schools');

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('info', InfoController::class)->name('info');
    Route::apiSingleton('profile', ProfileController::class);

    Route::apiResource('authors', AuthorController::class)->only('index', 'show');
    Route::apiResource('textbooks', TextbookController::class)->only('index', 'show');
    Route::apiResource('lessons', LessonController::class)->only('index', 'show');
    Route::apiResource('quizzes', QuizController::class)->only('index', 'show');
    Route::apiResource('tests', TestController::class)->except('destroy');
});
