<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('activities', ActivityController::class);

Route::patch('/activities/{activity}/publish',  [ActivityController::class, 'publish'])
    ->name('activities.publish');
Route::patch('/activities/{activity}/complete', [ActivityController::class, 'complete'])
    ->name('activities.complete');

Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');
Route::patch('/activities/{activity}/to-draft', [ActivityController::class, 'toDraft'])
    ->name('activities.toDraft');
    Route::patch('/activities/{id}/restore', [ActivityController::class, 'restore'])
    ->name('activities.restore');

Route::get('/', fn () => redirect()->route('activities.index'));