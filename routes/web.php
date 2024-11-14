<?php

use App\Http\Controllers\GameController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [GameController::class, 'index'])->name('dashboard');
    Route::post('/game', [GameController::class, 'store'])->name('start.game');
    Route::get('/game/{id}', [GameController::class, 'show'])->name('current.game');
    Route::put('/game/{id}', [GameController::class, 'update'])->name('update.game');
});
