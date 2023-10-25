<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => ['items' => $items],
        ]);
    }

    public function addToCart(Request $request)
    {
        $item = Item::find($request->itemId);
        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }
        $cacheKey = 'cartAPI:';
        $cart =   Cache::get($cacheKey, []);
        if (isset($cart[$request->itemId])) {
            $cart[$request->itemId]['quantity'] += 1;
        } else {
            $cart[$request->itemId] = [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price' => $item->price,
                'quantity' => 1,
            ];
        }

        Cache::put($cacheKey, $cart, now()->addMinutes(5));

        return response()->json([
            'status' => true,
            'message' => 'Item added to the cart.',
            'data' => [Cache::get($cacheKey, [])],
        ]);
    }
}
