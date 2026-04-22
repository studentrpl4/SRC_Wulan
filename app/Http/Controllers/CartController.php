<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
//     public function update(Request $request, Cart $cart)
// {
//     // pastikan hanya pemilik cart yang bisa update
//     if ($cart->customer_id !== auth('customer')->id()) {
//         abort(403);
//     }

//     if ($request->action === 'increase') {
//         $cart->quantity++;
//     } elseif ($request->action === 'decrease' && $cart->quantity > 1) {
//         $cart->quantity--;
//     }

//     $cart->subtotal = $cart->quantity * $cart->product->price;
//     $cart->save();

//     return back();
// }

public function updateQuantity(Request $request, Cart $cart)
{
    // pastikan hanya pemilik cart bisa update
    if ($cart->customer_id !== auth('customer')->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $action = $request->action;

    if ($action === 'increase') {
        $cart->quantity++;
    } elseif ($action === 'decrease' && $cart->quantity > 1) {
        $cart->quantity--;
    }

    $cart->subtotal = $cart->quantity * $cart->product->price;
    $cart->save();

    return response()->json([
        'quantity' => $cart->quantity,
        'subtotal' => number_format($cart->subtotal, 0, ',', '.')
    ]);
}


}
