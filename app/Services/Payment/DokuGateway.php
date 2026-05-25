<?php

namespace App\Services\Payment;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class DokuGateway implements PaymentGatewayInterface
{
    protected $config;

    public function __construct()
    {
        $this->config = config('doku');
        $base = $this->config['is_production'] ? $this->config['endpoints']['production'] : $this->config['endpoints']['sandbox'];
        $this->client = new Client(['base_uri' => $base, 'timeout' => 10.0]);
    }

    public function initiatePayment($order, array $options = []): array
    {
        $amount = $order->total_price ?? ($options['amount'] ?? 0);
        $invoice = $order->invoice ?? 'INV-' . Str::random(8);

        // Jokul standard payload
        $body = [
            'order' => [
                'amount' => (int) $amount,
                'invoice_number' => $invoice,
                'currency' => 'IDR',
                'callback_url' => route('front.index'), // URL for user to return to
            ],
            'payment' => [
                'payment_due_date' => 60, // 60 minutes
                'payment_method_types' => [
                    'VIRTUAL_ACCOUNT_BRI',
                    'EMONEY_OVO',
                    'EMONEY_SHOPEE_PAY',
                    'EMONEY_DANA',
                    'EMONEY_LINKAJA',
                    'QRIS'
                ]
            ],
            'customer' => [
                'name' => $order->customer->nama ?? ($options['customer']['name'] ?? 'Customer'),
                'email' => $order->customer->email ?? ($options['customer']['email'] ?? 'customer@example.com'),
                'phone' => $order->customer->phone ?? ($options['customer']['phone'] ?? ''),
            ]
        ];

        $jsonBody = json_encode($body);
        $requestId = Str::uuid()->toString();
        $requestTimestamp = gmdate("Y-m-d\TH:i:s\Z");
        $requestTarget = $this->config['endpoints']['direct_checkout']; // /checkout/v1/payment
        
        // Generate Jokul Signature
        $digest = base64_encode(hash('sha256', $jsonBody, true));
        $signatureComponent = "Client-Id:" . $this->config['client_id'] . "\n" .
                              "Request-Id:" . $requestId . "\n" .
                              "Request-Timestamp:" . $requestTimestamp . "\n" .
                              "Request-Target:" . $requestTarget . "\n" .
                              "Digest:" . $digest;
        $signature = base64_encode(hash_hmac('sha256', $signatureComponent, $this->config['secret_key'], true));

        try {
            $response = $this->client->post($requestTarget, [
                'headers' => [
                    'Client-Id' => $this->config['client_id'],
                    'Request-Id' => $requestId,
                    'Request-Timestamp' => $requestTimestamp,
                    'Signature' => "HMACSHA256=" . $signature,
                    'Content-Type' => 'application/json',
                ],
                'body' => $jsonBody,
            ]);

            $data = json_decode((string)$response->getBody(), true);

            // Handle standard Jokul Checkout response
            if (isset($data['response']) && isset($data['response']['payment'])) {
                $payment = $data['response']['payment'];
                $external = $data['response']['uuid'] ?? ($payment['token_id'] ?? null);
                $redirect = $payment['url'] ?? ($payment['payment_url'] ?? null);

                return [
                    'external_id' => $external,
                    'status' => 'menunggu',
                    'payload' => $data,
                    'redirect_url' => $redirect,
                ];
            }

            // Fallback generic mapping
            return [
                'external_id' => $data['external_reference_id'] ?? $data['reference'] ?? null,
                'status' => $data['status'] ?? 'pending',
                'payload' => $data,
                'redirect_url' => $data['redirect_url'] ?? $data['payment_url'] ?? null,
            ];
        } catch (\Throwable $e) {
            return [
                'external_id' => null,
                'status' => 'dibatalkan',
                'payload' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function handleCallback(array $payload, ?string $signatureHeader = null, ?string $rawBody = null): array
    {
        $secret = $this->config['secret_key'] ?? null;
        $verified = false;

        // Signature header format seen: "HMACSHA256=base64signature"
        if ($secret && $signatureHeader && $rawBody) {
            $parts = explode('=', $signatureHeader, 2);
            $hashAlgo = isset($parts[0]) ? strtolower($parts[0]) : 'hmacsha256';
            $sig = $parts[1] ?? $signatureHeader;

            // compute HMAC-SHA256 of the raw body and compare base64-encoded
            $computedRaw = base64_encode(hash_hmac('sha256', $rawBody, $secret, true));
            if (hash_equals($computedRaw, $sig) || hash_equals($computedRaw, base64_encode(hash('sha256', $rawBody, true)))) {
                $verified = true;
            }
        }

        return [
            'external_id' => $payload['transaction']['id'] ?? $payload['response']['uuid'] ?? $payload['reference'] ?? null,
            'status' => $payload['transaction']['status'] ?? $payload['response']['payment']['type'] ?? $payload['status'] ?? 'unknown',
            'invoice_number' => $payload['order']['invoice_number'] ?? null,
            'raw' => $payload,
            'verified' => $verified,
        ];
    }

    public function getStatus(string $externalId): array
    {
        // For DOKU, we query the status using the invoice number
        $requestId = Str::uuid()->toString();
        $requestTimestamp = gmdate("Y-m-d\TH:i:s\Z");
        $requestTarget = "/orders/v1/status/" . $externalId;

        // Signature component without Digest for GET
        $signatureComponent = "Client-Id:" . $this->config['client_id'] . "\n" .
                              "Request-Id:" . $requestId . "\n" .
                              "Request-Timestamp:" . $requestTimestamp . "\n" .
                              "Request-Target:" . $requestTarget;
        $signature = base64_encode(hash_hmac('sha256', $signatureComponent, $this->config['secret_key'], true));

        try {
            $response = $this->client->get($requestTarget, [
                'headers' => [
                    'Client-Id' => $this->config['client_id'],
                    'Request-Id' => $requestId,
                    'Request-Timestamp' => $requestTimestamp,
                    'Signature' => "HMACSHA256=" . $signature,
                ],
            ]);

            $data = json_decode((string)$response->getBody(), true);
            $status = $data['transaction']['status'] ?? 'unknown';

            return [
                'external_id' => $externalId,
                'status' => $status,
                'payload' => $data,
            ];
        } catch (\Throwable $e) {
            return [
                'external_id' => $externalId,
                'status' => 'error',
                'payload' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function refund(string $externalId, array $options = []): array
    {
        // Optional: implement refund via DOKU if needed
        return ['success' => false, 'message' => 'not_implemented'];
    }
}
