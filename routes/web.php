<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ChatbotController;
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
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');
    Route::get('/riwayat', [PredictionController::class, 'history'])->name('riwayat');

    Route::get('/edukasi', function () {
        return view('edukasi');
    })->name('edukasi');
});

require __DIR__.'/auth.php';
