<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsenceController; // Import the AbsenceController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom route for downloading absence justification
    Route::get('absences/{absence}/download', [AbsenceController::class, 'download'])->name('absences.download');

    // Resource route for absences
    Route::resource('absences', AbsenceController::class);
    
});

require __DIR__.'/auth.php';
