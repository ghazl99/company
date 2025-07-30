<?php

use Illuminate\Support\Facades\Route;
use Modules\WorkSession\Http\Controllers\WorkSessionController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('worksessions', WorkSessionController::class)->names('worksession');
});
