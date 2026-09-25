<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

// Task 1: dua route manual (index + show) — diganti menjadi resource route di Task 2.
// Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
// Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

// Task 2: resource route menggantikan route manual di atas.
// Menghasilkan otomatis: index, create, store, show, edit, update, destroy.
Route::resource('activities', ActivityController::class);

Route::get('/', function () {
    return redirect()->route('activities.index');
});
