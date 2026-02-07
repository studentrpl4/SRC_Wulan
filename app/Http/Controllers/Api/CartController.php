<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get current user's cart.
     */
    public function index(Request $request)
    {
        $carts = Cart::where('customer_id', $request->user()->id)
            ->with('product.category')
            ->get();

        $total = $carts->sum('subtotal');

        return response()->json([
            'carts' => $carts,
            'total' => $total
        ]);
    }

    /**
     * Add item to cart.
     */
    public function store(StoreCartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $user = $request->user();

        $cart = Cart::where('customer_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->subtotal = $cart->quantity * $product->price;
            $cart->save();
        } else {
            $cart = Cart::create([
                'customer_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart' => $cart
        ], 201);
    }

    /**
     * Update cart item quantity.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        // AUTHORIZATION CHECKS
         if ($cart->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
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
            'message' => 'Cart updated',
            'cart' => $cart
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Request $request, Cart $cart)
    {
        if ($cart->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json([
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }
}
