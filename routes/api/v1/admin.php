<?php

use App\Http\Controllers\Api\V1\Admin\AuthorController;
use App\Http\Controllers\Api\V1\Admin\DegreeController;
use App\Http\Controllers\Api\V1\Admin\DistrictController;
use App\Http\Controllers\Api\V1\Admin\InfoController;
use App\Http\Controllers\Api\V1\Admin\LessonController;
use App\Http\Controllers\Api\V1\Admin\PostController;
use App\Http\Controllers\Api\V1\Admin\PresentationController;
use App\Http\Controllers\Api\V1\Admin\ProfileController;
use App\Http\Controllers\Api\V1\Admin\QuestionController;
use App\Http\Controllers\Api\V1\Admin\QuizController;
use App\Http\Controllers\Api\V1\Admin\RatingUserController;
use App\Http\Controllers\Api\V1\Admin\RegionController;
use App\Http\Controllers\Api\V1\Admin\ReplyController;
use App\Http\Controllers\Api\V1\Admin\ReviewController;
use App\Http\Controllers\Api\V1\Admin\SchoolController;
use App\Http\Controllers\Api\V1\Admin\TestController;
use App\Http\Controllers\Api\V1\Admin\TextbookController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth:sanctum', 'ability:admin'],
], function () {
    Route::apiSingleton('profile', ProfileController::class);

    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('regions', RegionController::class);
    Route::apiResource('districts', DistrictController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class)->only('index');
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('infos', InfoController::class)->only('index', 'show', 'update');
    Route::apiResource('degrees', DegreeController::class)->only('index');
    Route::apiResource('textbooks', TextbookController::class);
    Route::apiResource('quizzes', QuizController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('lessons', LessonController::class);
    Route::apiResource('tests', TestController::class)->only('index', 'show');
    Route::apiResource('rating/users', RatingUserController::class)->only('index');
    Route::apiResource('presentations', PresentationController::class);
    Route::apiResource('reviews', ReviewController::class)->except('store');
    Route::apiResource('replies', ReplyController::class)->except('index', 'show');
});
