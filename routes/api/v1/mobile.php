<?php

use App\Http\Controllers\Api\V1\Front\TextbookController;
use App\Http\Controllers\Api\V1\Mobile\AuthorController;
use App\Http\Controllers\Api\V1\Mobile\DistrictController;
use App\Http\Controllers\Api\V1\Mobile\InfoController;
use App\Http\Controllers\Api\V1\Mobile\LessonController;
use App\Http\Controllers\Api\V1\Mobile\PostController;
use App\Http\Controllers\Api\V1\Mobile\ProfileController;
use App\Http\Controllers\Api\V1\Mobile\QuizController;
use App\Http\Controllers\Api\V1\Mobile\SchoolController;
use App\Http\Controllers\Api\V1\Mobile\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'mobile',
    'as' => 'mobile.',
], function () {
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
        Route::apiResource('rating/users', RatingUserController::class)->only('index');
    });
});

