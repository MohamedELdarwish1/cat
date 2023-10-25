<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['api'])->group(function () {


    Route::get('/items', [\App\Http\Controllers\API\ItemController::class, 'index'])->name('ListItems');
    Route::post('items/add-to-cart', [\App\Http\Controllers\API\ItemController::class, 'addToCart']);


    Route::get('cart', [\App\Http\Controllers\API\CartController::class, 'index']);
    Route::post('cart/update', [\App\Http\Controllers\API\CartController::class, 'updateCart']);
    Route::delete('cart/remove/', [\App\Http\Controllers\API\CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('payment', [\App\Http\Controllers\API\CartController::class, 'payment']);
});
