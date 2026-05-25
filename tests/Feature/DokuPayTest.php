<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\Order;
use App\Models\transaksi;

class DokuPayTest extends TestCase
{
    use RefreshDatabase;

    public function test_doku_pay_redirects_to_gateway()
    {
        // Arrange: create customer, order, transaksi and bind a stub gateway
        $customer = Customer::create(["nama" => "Test", "email" => "t@t.com", 'password' => bcrypt('secret')]);
        $order = Order::create(["customer_id" => $customer->id, "invoice" => 'INV-TEST', "address" => 'addr', "payment_method" => 'transfer', "total_price" => 10000]);

        $trans = transaksi::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'status' => 'menunggu',
            'snap_token' => null,
            'payment_provider' => 'doku'
        ]);

        // Bind a simple stub to DokuGateway class used by controller
        // Create a stub class that extends the real DokuGateway so PHP type-hinting is satisfied
        $stub = new class extends \App\Services\Payment\DokuGateway {
            public function __construct() {}
            public function initiatePayment($order, array $options = []): array {
                return ['external_id' => 'EXT-TEST', 'status' => 'pending', 'redirect_url' => 'https://example.com/pay'];
            }
        };

        $this->app->instance(\App\Services\Payment\PaymentGatewayInterface::class, $stub);

        // Act: act as customer and hit pay route
        $this->actingAs($customer, 'customer');
        $response = $this->get('/doku/pay/' . $trans->id);

        $response->assertRedirect('https://example.com/pay');
    }
}
