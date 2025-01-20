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

// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\AbsenceController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     // Profile routes
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     // Absence routes
//     Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index'); // List absences
//     Route::get('/absences/{absence}', [AbsenceController::class, 'show'])->name('absences.show'); // Show single absence

//     // Teacher-specific routes (create, store, edit, update, delete)
//     Route::middleware('can:create,App\Models\Absence')->group(function () {
//         Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');
//         Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
//         Route::get('/absences/{absence}/edit', [AbsenceController::class, 'edit'])->name('absences.edit');
//         Route::patch('/absences/{absence}', [AbsenceController::class, 'update'])->name('absences.update');
//         Route::delete('/absences/{absence}', [AbsenceController::class, 'destroy'])->name('absences.destroy');
//     });
// });

// require __DIR__.'/auth.php';
