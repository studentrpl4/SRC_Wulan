<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Get customer orders.
     */
    public function index(Request $request)
    {
        $customerId = $request->user()->id;

        $allorder = Order::where('customer_id', $customerId)->latest()->get();
        $ongoing = Order::where('customer_id', $customerId)
            ->whereIn('status', ['processing', 'shipped'])
            ->latest()
            ->get();
        $history = Order::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return response()->json([
            'all_orders' => $allorder,
            'ongoing' => $ongoing,
            'history' => $history
        ]);
    }

    /**
     * Show specific order details.
     */
    public function show(Request $request, $id)
    {
        $order = Order::with('order_items.product', 'customer')->findOrFail($id);

        if ($order->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order' => $order
        ]);
    }
}
