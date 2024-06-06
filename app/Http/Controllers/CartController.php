<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
{
    $cart = session()->get('cart', []);
    $item = [
        'id' => $request->id,
        'name' => $request->name,
        'price' => $request->price,
        'category' => $request->category,
    ];
    $cart[$request->id] = $item; // Use ID as key to avoid duplicates
    session(['cart' => $cart]);
    return redirect()->back()->with('success', 'Item added to cart');
}
}
