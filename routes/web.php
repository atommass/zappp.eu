<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LinkController::class, 'index'])->name('dashboard');
    Route::post('/links/store', [LinkController::class, 'store'])->name('links.store');
    Route::delete('/links/{link}/destroy', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::patch('/links/{link}/update', [LinkController::class, 'update'])->name('links.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{link:slug}/unlock', [RedirectController::class, 'unlockForm'])->name('links.unlock');
Route::post('/{link:slug}/unlock', [RedirectController::class, 'unlock'])->name('links.unlock.submit');
Route::get('/{link:slug}', [RedirectController::class, '__invoke'])->name('links.redirect');
