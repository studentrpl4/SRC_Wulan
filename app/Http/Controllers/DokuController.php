<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Support\Log;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DokuController extends Controller
{
    protected $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function handleCallback(Request $request)
    {
        $payload = $request->all();
        $signatureHeader = $request->header('signature') ?? $request->header('x-doku-signature');
        $rawBody = $request->getContent();

        // Let the gateway normalize and verify the payload using raw body and signature header.
        $result = $this->gateway->handleCallback($payload, $signatureHeader, $rawBody);

        // Map DOKU status to local transaksi.status values
        $externalId = $result['external_id'] ?? null;
        $status = $result['status'] ?? 'unknown';
        $invoiceNumber = $result['invoice_number'] ?? ($payload['order']['invoice_number'] ?? null);

        // Find transaksi by invoice number first (most reliable)
        $transaksi = null;
        if ($invoiceNumber) {
            $transaksi = \App\Models\transaksi::whereHas('order', function ($query) use ($invoiceNumber) {
                $query->where('invoice', $invoiceNumber);
            })->first();
        }

        if (!$transaksi && $externalId) {
            $transaksi = \App\Models\transaksi::where('external_reference_id', $externalId)->first();
        }

        if (!$transaksi && isset($payload['order_id'])) {
            $transaksi = \App\Models\transaksi::where('order_id', $payload['order_id'])->first();
        }

        if ($transaksi) {
            if (in_array(strtolower($status), ['success', 'settlement', 'paid', 'completed', 'sale'])) {
                $transaksi->status = 'berhasil';
            } elseif (in_array(strtolower($status), ['pending', 'waiting'])) {
                $transaksi->status = 'menunggu';
            } elseif (in_array(strtolower($status), ['failed', 'cancel', 'expired', 'deny'])) {
                $transaksi->status = 'dibatalkan';
            }

            if (!empty($externalId)) {
                $transaksi->external_reference_id = $externalId;
            }

            $transaksi->save();
        }

        return response()->json(['ok' => true]);
    }

    public function pay($transaksiId)
    {
        $transaksi = \App\Models\transaksi::find($transaksiId);
        if (!$transaksi) {
            return redirect()->route('customer.orders')->with('error', 'Transaksi tidak ditemukan');
        }

        $order = $transaksi->order;
        try {
            $result = $this->gateway->initiatePayment($order, ['transaksi' => $transaksi]);

            // Update transaksi with external id if present
            if (!empty($result['external_id'])) {
                $transaksi->external_reference_id = $result['external_id'];
                $transaksi->save();
            }

            if (!empty($result['redirect_url'])) {
                return redirect()->away($result['redirect_url']);
            }

            return redirect()->route('customer.orders')->with('info', 'Pembayaran diinisiasi (sandbox).');
        } catch (\Throwable $e) {
            Log::error('Doku pay error: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('customer.orders')->with('error', 'Gagal inisiasi pembayaran.');
        }
    }

    // Development-only mock endpoint to simulate a successful DOKU payment
    public function mockSuccess($orderId)
    {
        $transaksi = \App\Models\transaksi::where('order_id', $orderId)->first();
        if ($transaksi) {
            $transaksi->status = 'berhasil';
            $transaksi->external_reference_id = 'MOCK-DOKU-' . $orderId . '-' . time();
            $transaksi->save();
        }

        return redirect()->route('customer.orders')->with('success', 'Mock payment completed');
    }
}
