<?php

use Illuminate\Support\Facades\Route;
use Modules\WorkSession\Http\Controllers\WorkSessionController;

Route::middleware('auth')->group(function () {
    Route::get('/work-session', [WorkSessionController::class, 'status'])->name('work.session');
    Route::post('/work-session/start', [WorkSessionController::class, 'start'])->name('work.session.start');
    Route::post('/work-session/end', [WorkSessionController::class, 'end'])->name('work.session.end');
});
