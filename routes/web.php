<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/items', \App\Http\Controllers\ItemController::class);
Route::post('/items/{item}/add-to-cart', [ \App\Http\Controllers\ItemController::class, 'addToCart'])->name('cart.add');

Route::resource('/cart', \App\Http\Controllers\CartController::class);
Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{item}', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/payment', [\App\Http\Controllers\CartController::class, 'proceedToPayment'])->name('payment');
Route::post('/cart/payment', [App\Http\Controllers\CartController::class, 'processPayment'])->name('process-payment');
Route::get('/cart/payment/result/', [App\Http\Controllers\CartController::class, 'showTransactionResult'])->name('transaction-result');

