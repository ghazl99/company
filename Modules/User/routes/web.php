<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Admin\UserController;
use Modules\User\Http\Controllers\AuthenticatedController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class)->names('user');
});
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedController::class, 'store']);
});
Route::middleware('auth')->group(function () {
    Route::get('/user/image/{media}', [UserController::class, 'showImage'])->name('user.image');
    Route::get('/user/cv/{media}', [UserController::class, 'showCv'])->name('user.cv');

    Route::post('logout', [AuthenticatedController::class, 'destroy'])
        ->name('logout');
});
