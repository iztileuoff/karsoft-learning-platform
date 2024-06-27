<?php

use App\Http\Controllers\Api\V1\Admin\AuthorController;
use App\Http\Controllers\Api\V1\Admin\DegreeController;
use App\Http\Controllers\Api\V1\Admin\InfoController;
use App\Http\Controllers\Api\V1\Admin\LessonController;
use App\Http\Controllers\Api\V1\Admin\PostController;
use App\Http\Controllers\Api\V1\Admin\QuestionController;
use App\Http\Controllers\Api\V1\Admin\QuizController;
use App\Http\Controllers\Api\V1\Admin\TextbookController;
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
    Route::apiResource('textbooks', TextbookController::class);
    Route::apiResource('quizzes', QuizController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('lessons', LessonController::class);
});
