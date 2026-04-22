<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $customerId = auth('customer')->id();

        // yang statusnya belum selesai
        $allorder = Order::where('customer_id', $customerId)->latest()->get();
        $ongoing = Order::where('customer_id', $customerId)
            ->whereIn('status', ['processing', 'shipped'])
            ->latest()
            ->get();

        // yang sudah selesai
        $history = Order::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('front.orders.index', compact('ongoing', 'history','allorder'));
    }

    //     public function show(Order $order)
    // {
    //     // Pastikan customer hanya bisa lihat pesanan miliknya sendiri
    //     if ($order->customer_id !== auth('customer')->id()) {
    //         abort(403);
    //     }

    //     // Ambil item pesanan beserta product-nya
    //     $order->load('items.product');

    //     return view('front.orders.show', compact('order'));
    // }

    public function showDetail($id)
    {
        $order = Order::with('order_items.product', 'customer')->findOrFail($id);

        // pastikan hanya pemilik order bisa lihat
        if ($order->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        return view('front.orders.showDetail', compact('order'));
    }


    // public function track(Order $order)
    // {
    //     if ($order->customer_id !== auth('customer')->id()) {
    //         abort(403);
    //     }

    //     return view('front.orders.track', compact('order'));
    // }
}
