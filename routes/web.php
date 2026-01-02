<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/cookie-policy', 'legal.cookie-policy')->name('cookie.policy');

Route::get('/email-logo', function () {
    $path = public_path('zippp.eu.png');

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->name('email.logo');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [LinkController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/qr/{code}', [\App\Http\Controllers\QrCodeController::class, 'show'])->name('qr.show');
    Route::get('/qr/{code}/download', [\App\Http\Controllers\QrCodeController::class, 'download'])->name('qr.download');

    Route::post('/links/store', [LinkController::class, 'store'])->name('links.store');
    Route::delete('/links/{link}/destroy', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::patch('/links/{link}/update', [LinkController::class, 'update'])->name('links.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Support page */
Route::get('support', [\App\Http\Controllers\SupportController::class, 'create'])
    ->name('support');

Route::post('support', [\App\Http\Controllers\SupportController::class, 'store'])
    ->name('support.send');

require __DIR__.'/auth.php';

Route::get('/{link:slug}/unlock', [RedirectController::class, 'unlockForm'])->name('links.unlock');
Route::post('/{link:slug}/unlock', [RedirectController::class, 'unlock'])->name('links.unlock.submit');
Route::get('/{link:slug}', [RedirectController::class, '__invoke'])->name('links.redirect');
