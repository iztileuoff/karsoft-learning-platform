<?php

use App\Http\Controllers\Api\V1\Admin\Auth\LoginController;
use App\Http\Controllers\Api\V1\Admin\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin/auth',
    'as' => 'admin.auth.',
], function () {
    Route::post('login', LoginController::class)->name('login');
    Route::delete('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum', 'ability:admin');
});
