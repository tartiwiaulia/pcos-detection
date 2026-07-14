<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [PredictionController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pemeriksaan', function () {
        return view('pemeriksaan');
    })->name('pemeriksaan');

    Route::post('/pemeriksaan', [PredictionController::class, 'store'])->name('predictions.store');
    Route::get('/riwayat', [PredictionController::class, 'history'])->name('riwayat');
    Route::get('/riwayat/{prediction}', [PredictionController::class, 'show'])->name('predictions.show');
    Route::delete('/riwayat/{prediction}', [PredictionController::class, 'destroy'])->name('predictions.destroy');

    Route::get('/edukasi', function () {
        return view('edukasi');
    })->name('edukasi');
});

require __DIR__.'/auth.php';
