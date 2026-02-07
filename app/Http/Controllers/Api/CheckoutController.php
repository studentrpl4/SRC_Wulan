<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Process checkout.
     */
    public function process(CheckoutRequest $request)
    {
        $user = $request->user();

        // Get cart items
        $cartItems = Cart::with('product')
            ->where('customer_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Keranjang masih kosong!'], 400);
        }

        $total = $cartItems->sum('subtotal');
        $invoice = 'INV-' . strtoupper(Str::random(10));

        // Create Order
        $order = Order::create([
            'customer_id' => $user->id,
            'invoice' => $invoice,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $total,
            'status' => 'processing'
        ]);

        // Create Order Items
        foreach ($cartItems as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
                'subtotal' => $cart->subtotal,
            ]);
        }

        $snapToken = null;

        if ($request->payment_method == 'transfer') {
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $payload = [
                'transaction_details' => [
                    'order_id' => 'Produk' . '-' . $order->id . '-' . time(),
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'name' => $user->name ?? 'nama tidak diketahui',
                    'email' => $user->email ?? 'customer@mail.com',
                    'billing_address' => [
                        'address' => $request->address,
                    ],
                ],
            ];

             $snapToken = Snap::getSnapToken($payload);

             transaksi::create([
                'customer_id' => $user->id,
                'order_id' => $order->id,
                'status' => 'menunggu',
                'snap_token' => $snapToken,
            ]);
        } else {
            // Manual / COD
             transaksi::create([
                'customer_id' => $user->id,
                'order_id' => $order->id,
                'status' => 'menunggu',
                'snap_token' => null,
            ]);
        }
        
        // Clear Cart
        Cart::where('customer_id', $user->id)->delete();

        return response()->json([
            'message' => 'Pesanan berhasil dibuat!',
            'order' => $order,
            'snap_token' => $snapToken
        ], 201);
    }
}
