<?php

use App\Http\Controllers\Api\V1\Front\Auth\LoginController;
use App\Http\Controllers\Api\V1\Front\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Front\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
], function () {
    Route::post('registration', RegistrationController::class)->name('registration');
    Route::post('login', LoginController::class)->name('login');
    Route::delete('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');
});
