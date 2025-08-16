<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotController;
use App\Http\Controllers\LeconController;
use App\Http\Controllers\LanguageController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/vocabulaire', [MotController::class, 'index'])->name('vocabulaire.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/lecon', [LeconController::class, 'index'])->name('lecon.index');
});


// Route pour changer la langue
Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('language.change');

// Route pour récupérer la langue actuelle (optionnelle)
Route::get('/current-language', [LanguageController::class, 'getCurrentLanguage'])->name('language.current');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
