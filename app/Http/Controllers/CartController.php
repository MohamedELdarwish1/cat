<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('cart', ['cartItems' => $cartItems]);
    }
    public function updateCart(Request $request)
    {


        $quantities = $request->input('quantities');
        $cart = session()->get('cart', []);
        foreach ($quantities as $itemId => $quantity) {
            if (isset($cart[$itemId]) && is_numeric($quantity) && $quantity >= 1) {
                $cart[$itemId]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function removeFromCart($itemId)
    {


        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Item removed from the cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in the cart.');

    }

    public function proceedToPayment()
    {

        $cartItems = session()->get('cart', []);


        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }


        // session()->forget('cart');

        return view('payment');


    }

     public function processPayment(Request $request)
{
    // Validate the form input (e.g., address and telephone number)
    $request->validate([
        'address' => 'required',
        'telephone' => 'required',
    ]);

    // Get the cart items from the session
    $cartItems = session()->get('cart', []);

    $totalPrice = 0;

    foreach ($cartItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
    // Update store credits and save the transaction in the database
    // Implement the necessary logic to update store credits and save the transaction to the database

    // Clear the cart after a successful transaction
    session()->forget('cart');

    // return redirect()->route('transaction-result', ['result' => 'success']);
     return redirect()->back()->with('success', 'Success');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
