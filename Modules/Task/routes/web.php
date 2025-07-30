<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\TaskController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tasks', TaskController::class)->names('task');
    Route::get('task/image/{media}', [TaskController::class, 'showImage'])->name('task.image');
    Route::patch('/tasks/{task}/status/{developer}', [TaskController::class, 'changeStatus'])->name('task.changeStatus');

});
