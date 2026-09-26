<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return '<h1>Laravel is working!</h1>';
});
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');