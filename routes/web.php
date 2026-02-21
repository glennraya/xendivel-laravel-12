<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use GlennRaya\Xendivel\Xendivel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::post('/pay-with-card', function (Request $request) {
    $payment = Xendivel::payWithCard($request)
        ->getResponse();

    return $payment;
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
