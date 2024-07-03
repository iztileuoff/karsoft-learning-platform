<?php

use App\Http\Controllers\Api\V1\Mobile\Auth\LoginController;
use App\Http\Controllers\Api\V1\Mobile\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Mobile\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'mobile/auth',
    'as' => 'mobile.auth.',
], function () {
    Route::post('registration', RegistrationController::class)->name('registration');
    Route::post('login', LoginController::class)->name('login');
    Route::delete('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');
});
