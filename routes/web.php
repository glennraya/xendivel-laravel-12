<?php

use GlennRaya\Xendivel\Invoice;
use GlennRaya\Xendivel\Xendivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/xendivel/invoice/generate', function () {
    $invoice_data = [
        'invoice_number' => 1000023,
        'card_type' => 'VISA',
        'masked_card_number' => '400000XXXXXX0002',
        'merchant' => [
            'name' => 'Xendivel LLC',
            'address' => '152 Maple Avenue Greenfield, New Liberty, Arcadia USA 54331',
            'phone' => '+63 971-444-1234',
            'email' => 'xendivel@example.com',
        ],
        'customer' => [
            'name' => 'Lana Blakely',
            'address' => 'Alex Johnson, 4457 Pine Circle, Rivertown, Westhaven, 98765, Silverland',
            'email' => 'victoria@example.com',
            'phone' => '+63 909-098-654',
        ],
        'items' => [
            ['item' => 'iPhone 17 Pro Max', 'price' => 1099, 'quantity' => 5],
            ['item' => 'MacBook Pro 16" M5 Max', 'price' => 2499, 'quantity' => 3],
            ['item' => 'Apple Studio Display XDR', 'price' => 4000, 'quantity' => 2],
        ],
        'tax_rate' => .12,
        'tax_id' => '123-456-789',
        'footer_note' => 'Thank you for your recent purchase with us! We are thrilled to have the opportunity to serve you and hope that your new purchase brings you great satisfaction.',
    ];

    return Invoice::make($invoice_data)
        ->download();
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
