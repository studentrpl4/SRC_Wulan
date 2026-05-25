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

        // Sinkronisasi status transaksi DOKU secara real-time jika masih "menunggu"
        foreach ($allorder as $order) {
            $transaksi = $order->transaksi;
            if ($transaksi && $transaksi->status === 'menunggu' && $transaksi->payment_provider === 'doku') {
                try {
                    $doku = app()->make(\App\Services\Payment\PaymentGatewayInterface::class);
                    $statusResult = $doku->getStatus($order->invoice);
                    $status = $statusResult['status'] ?? 'unknown';

                    if (in_array(strtolower($status), ['success', 'settlement', 'paid', 'completed', 'sale'])) {
                        $transaksi->status = 'berhasil';
                        $transaksi->save();
                    } elseif (in_array(strtolower($status), ['failed', 'cancel', 'expired', 'deny'])) {
                        $transaksi->status = 'dibatalkan';
                        $transaksi->save();
                    }
                } catch (\Throwable $e) {
                    // Abaikan error koneksi agar halaman tetap termuat cepat
                }
            }
        }

        // Ambil ulang data terupdate setelah sinkronisasi
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

        // Sinkronisasi status transaksi DOKU secara real-time jika masih "menunggu"
        $transaksi = $order->transaksi;
        if ($transaksi && $transaksi->status === 'menunggu' && $transaksi->payment_provider === 'doku') {
            try {
                $doku = app()->make(\App\Services\Payment\PaymentGatewayInterface::class);
                $statusResult = $doku->getStatus($order->invoice);
                $status = $statusResult['status'] ?? 'unknown';

                if (in_array(strtolower($status), ['success', 'settlement', 'paid', 'completed', 'sale'])) {
                    $transaksi->status = 'berhasil';
                    $transaksi->save();
                    // Reload order relations to reflect updated transaction status in view
                    $order->load('transaksi');
                } elseif (in_array(strtolower($status), ['failed', 'cancel', 'expired', 'deny'])) {
                    $transaksi->status = 'dibatalkan';
                    $transaksi->save();
                    $order->load('transaksi');
                }
            } catch (\Throwable $e) {
                // Abaikan error koneksi agar halaman tetap termuat cepat
            }
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
