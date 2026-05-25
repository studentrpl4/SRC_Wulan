<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Order;
use App\Models\transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.defaults.guard' => 'customer']);
    }

    /** @test */
    public function customer_can_view_orders_index()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'invoice' => 'INV-INDEX-TEST',
            'address' => 'Jakarta',
            'payment_method' => 'transfer',
            'total_price' => 12000,
            'status' => 'processing',
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->get('/orders');
        $response->assertStatus(200);
        $response->assertViewIs('front.orders.index');
        $response->assertViewHas('ongoing');
    }

    /** @test */
    public function orders_index_performs_realtime_doku_polling()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'invoice' => 'INV-POLL-TEST',
            'address' => 'Jakarta',
            'payment_method' => 'transfer',
            'total_price' => 12000,
            'status' => 'processing',
        ]);

        $transaksi = transaksi::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'status' => 'menunggu',
            'payment_provider' => 'doku',
        ]);

        $this->actingAs($customer, 'customer');

        // Configure mock Payment Gateway
        $dokuMock = new class extends \App\Services\Payment\DokuGateway {
            public function __construct() {}
            public function getStatus($invoice): array {
                return ['status' => 'SUCCESS']; // Simulate a successful payment status returned by DOKU API
            }
        };
        $this->app->instance(\App\Services\Payment\PaymentGatewayInterface::class, $dokuMock);

        $response = $this->get('/orders');
        $response->assertStatus(200);

        $transaksi->refresh();
        $this->assertEquals('berhasil', $transaksi->status);
    }

    /** @test */
    public function customer_can_view_order_details()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'invoice' => 'INV-DETAIL-TEST',
            'address' => 'Jakarta',
            'payment_method' => 'transfer',
            'total_price' => 12000,
            'status' => 'processing',
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->get("/orders/{$order->id}");
        $response->assertStatus(200);
        $response->assertViewIs('front.orders.showDetail');
        $response->assertViewHas('order');
    }
}
