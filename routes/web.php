<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__.'/auth.php';

Route::get('/geheim', function () {
    return view('geheim');
})->middleware('auth');

// Klanten en admins mogen het overzicht zien.
Route::get('/games', [GameController::class, 'index'])
    ->middleware(['auth', 'role:admin|klant']);

// Alleen admins mogen de overige gamepagina's en acties gebruiken.
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/games/show/{id}', [GameController::class, 'show']);
    Route::get('/games/create', [GameController::class, 'create']);
    Route::post('/games/store', [GameController::class, 'store']);
    Route::get('/games/edit/{id}', [GameController::class, 'edit']);
    Route::post('/games/update/{id}', [GameController::class, 'update']);
    Route::post('/games/destroy/{id}', [GameController::class, 'destroy']);
});