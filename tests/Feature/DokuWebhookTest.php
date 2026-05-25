<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\transaksi;
use App\Models\Order;
use App\Models\Customer;

class DokuWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_doku_webhook_updates_transaksi_status()
    {
        // Arrange: create customer, order and transaksi
        $customer = Customer::create(["nama" => "Test", "email" => "t@t.com", 'password' => bcrypt('secret')]);
        $order = Order::create(["customer_id" => $customer->id, "invoice" => 'INV-TEST', "address" => 'addr', "payment_method" => 'transfer', "total_price" => 10000]);

        $trans = transaksi::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'status' => 'menunggu',
            'snap_token' => null,
            'payment_provider' => 'doku'
        ]);

        // Ensure transaksi has the expected external_reference_id so the webhook handler can find it
        $trans->external_reference_id = 'EXT-123';
        $trans->save();

        // Set a known secret for signature
        config(['doku.secret_key' => 'test_secret']);

        // Ensure the controller receives a real DokuGateway via the interface
        $this->app->instance(\App\Services\Payment\PaymentGatewayInterface::class, new \App\Services\Payment\DokuGateway());

        $payload = [
            'response' => [
                'uuid' => 'EXT-123',
                'payment' => [
                    'type' => 'SALE'
                ]
            ]
        ];

        $raw = json_encode($payload);
        $sig = base64_encode(hash_hmac('sha256', $raw, config('doku.secret_key'), true));
        $header = 'HMACSHA256=' . $sig;

        // Act: call webhook
        $response = $this->withHeaders(['signature' => $header])->postJson('/doku/callback', $payload);

        $response->assertStatus(200);

        $trans->refresh();
        $this->assertEquals('berhasil', $trans->status);
        $this->assertEquals('EXT-123', $trans->external_reference_id);
    }
}
