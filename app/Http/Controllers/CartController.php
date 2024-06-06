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
        'image' => $request->image?? 'public/images/categories/1717481936_sedan-wlu.png', // Use a default image path if 'image' isn't provided
    ];
    $cart[$request->id] = $item; // Use ID as key to avoid duplicates
    session(['cart' => $cart]);
    return redirect()->back()->with('success', 'Item added to cart');
}

public function removeFromCart($id)
{
    $cart = session()->get('cart');
    unset($cart[$id]);
    session(['cart' => $cart]);
    return redirect()->back()->with('success', 'Item removed from cart');
}
}
