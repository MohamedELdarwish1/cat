<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function index()
    {

        $cacheKey = 'cartAPI:';
        $cartItems = Cache::get($cacheKey, []);
        return response()->json([
            'status' => true,
            'message' => 'cart items',
            'data' => ['items' => $cartItems],
        ]);
    }

    public function removeFromCart(Request $request)
    {


        $cacheKey = 'cartAPI:';
        $cart = Cache::get($cacheKey, []);

        if (isset($cart[$request->itemId])) {
            unset($cart[$request->itemId]);
            Cache::put($cacheKey, $cart, now()->addMinutes(5));
            return response()->json([
                'status' => true,
                'message' => 'item removed successfuly',
                'data' => ['items' => $cart],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Item not found in the cart.',
            'data' => ['items' => $cart],
        ]);
    }

    public function updateCart(Request $request)
    {


        $quantities = $request->input('quantities');
        $cacheKey = 'cartAPI:';
        $cart = Cache::get($cacheKey, []);
        foreach ($quantities as $itemId => $quantity) {
            if (isset($cart[$itemId]) && is_numeric($quantity) && $quantity >= 1) {
                $cart[$itemId]['quantity'] = $quantity;
            }
        }

        Cache::put($cacheKey, $cart, now()->addMinutes(5));
        return response()->json([
            'status' => true,
            'message' => 'cart Updated  successfuly',
            'data' => ['cart' => $cart],
        ]);
    }

    public function payment(Request $request)
    {
        $cacheKey = 'cartAPI:';
        $cart = Cache::get($cacheKey, []);
        if (empty($cart)) {
            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty.',
                'data' => [],
            ]);
        }
        $request->validate([
            'address' => 'required',
            'telephone' => 'required',
        ]);
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        //as you mention in the documentation lets assume the customer is alredy authed, so lets assume that i know the current customer
        $customer = Customer::first();
        if ($customer->store_credit >= $totalPrice) {
            Order::create([
                'customer_id' => $customer->id,
                'total' => $totalPrice,
                'address' => $request->address,
                'telephone' => $request->telephone,
            ]);

            $customer->store_credit = ($customer->store_credit - $totalPrice);
            $customer->save();

            Cache::forget($cacheKey);
            return response()->json([
                'status' => true,
                'message' => 'Your Transaction done Successfuly',
                'data' => [],
            ]);
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Your dont have enough store balance .',
                'data' => [],
            ]);
        }
    }
}
