<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', function () {
    throw new NotFoundHttpException();
})->name('login');

Route::get('/test', function () {
    \App\Models\User::create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'is_admin' => true,
        'phone' => '998999999999',
        'email' => null,
        'password' => '12344321',
        'post_id' => 1,
        'district_id' => 9,
        'school_id' => 1,
        'google_id' => null,
        'telegram_id' => null,
    ]);
});

