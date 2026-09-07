<?php

use App\Http\Controllers\Api\V1\Front\AuthorController;
use App\Http\Controllers\Api\V1\Front\AiAttachmentController;
use App\Http\Controllers\Api\V1\Front\GeminiChatController;
use App\Http\Controllers\Api\V1\Front\DistrictController;
use App\Http\Controllers\Api\V1\Front\InfoController;
use App\Http\Controllers\Api\V1\Front\LessonController;
use App\Http\Controllers\Api\V1\Front\PostController;
use App\Http\Controllers\Api\V1\Front\PresentationController;
use App\Http\Controllers\Api\V1\Front\ProfileController;
use App\Http\Controllers\Api\V1\Front\QuizController;
use App\Http\Controllers\Api\V1\Front\RatingTestController;
use App\Http\Controllers\Api\V1\Front\RatingUserController;
use App\Http\Controllers\Api\V1\Front\RegionController;
use App\Http\Controllers\Api\V1\Front\ReviewController;
use App\Http\Controllers\Api\V1\Front\SchoolController;
use App\Http\Controllers\Api\V1\Front\TestAnswerController;
use App\Http\Controllers\Api\V1\Front\TestController;
use App\Http\Controllers\Api\V1\Front\TestQuestionController;
use App\Http\Controllers\Api\V1\Front\TextbookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Front\SubjectController;

Route::get('posts', PostController::class)->name('posts');
Route::get('regions', RegionController::class)->name('regions');
Route::get('districts', DistrictController::class)->name('districts');
Route::get('schools', SchoolController::class)->name('schools');

Route::group([
    'middleware' => ['auth:sanctum', 'ability:front'],
], function () {
    Route::get('info', InfoController::class)->name('info');
    Route::get('subjects', SubjectController::class)->name('subjects');
    Route::apiSingleton('profile', ProfileController::class);
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::apiResource('authors', AuthorController::class)->only('index', 'show');
    Route::apiResource('textbooks', TextbookController::class)->only('index', 'show');
    Route::apiResource('lessons', LessonController::class)->only('index', 'show');
    Route::apiResource('quizzes', QuizController::class)->only('index', 'show');
    Route::apiResource('tests', TestController::class)->except('destroy');
    Route::apiResource('tests.questions', TestQuestionController::class)->only('index');
    Route::apiResource('tests.answers', TestAnswerController::class)->only('index');
    Route::apiResource('presentations', PresentationController::class)->only('index', 'show');
    Route::apiResource('rating/users', RatingUserController::class)->only('index');
    Route::apiResource('rating/tests', RatingTestController::class)->only('index');
    Route::apiResource('reviews', ReviewController::class);

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [GeminiChatController::class, 'index'])->name('index');
        Route::post('/', [GeminiChatController::class, 'store'])->name('store');
        Route::get('{conversation}', [GeminiChatController::class, 'show'])->name('show');
        Route::delete('{conversation}', [GeminiChatController::class, 'destroy'])->name('destroy');

        Route::post('attachments', [AiAttachmentController::class, 'store'])->name('attachments.store');
    });
});
