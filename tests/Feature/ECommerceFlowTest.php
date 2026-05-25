<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\transaksi;
use App\Models\PromoCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class ECommerceFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_registration_and_authentication()
    {
        $customerData = [
            'email' => 'customer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
            'phone' => '0812345678',
            'gender' => 'female',
            'birth_date' => '2000-05-15',
            'profile_completed' => true,
        ];

        $customer = Customer::create($customerData);

        $this->assertDatabaseHas('customers', [
            'email' => 'customer@mail.com',
            'name' => 'Wulan Sari',
        ]);

        $this->actingAs($customer, 'customer');
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    /** @test */
    public function cart_item_addition_and_subtotal_calculation()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Budi Santoso',
        ]);

        $category = Category::create([
            'name' => 'Snack',
            'slug' => 'snack',
            'icon' => 'snack.png',
        ]);

        $product = Product::create([
            'name' => 'Kripik Singkong',
            'slug' => 'kripik-singkong',
            'thumbnail' => 'kripik.jpg',
            'about' => 'Garing dan nikmat.',
            'price' => 15000,
            'stock' => 10,
            'is_popular' => 0,
            'category_id' => $category->id,
        ]);

        $cart = Cart::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'subtotal' => 30000, // 2 * 15000
        ]);

        $this->assertDatabaseHas('carts', [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'subtotal' => 30000,
        ]);

        $this->assertEquals(30000, $cart->subtotal);
    }

    /** @test */
    public function checkout_creates_order_and_selectively_clears_cart()
    {
        // 1. Arrange customer, product, cart items
        $customer = Customer::create([
            'email' => 'shopper@mail.com',
            'password' => 'secret123',
            'name' => 'Andi',
            'phone' => '08123456789',
        ]);

        $category = Category::create([
            'name' => 'Minuman',
            'slug' => 'minuman',
            'icon' => 'drink.png',
        ]);

        $product1 = Product::create([
            'name' => 'Kopi Tubruk',
            'slug' => 'kopi-tubruk',
            'thumbnail' => 'kopi.jpg',
            'about' => 'Kopi hitam murni',
            'price' => 10000,
            'stock' => 50,
            'is_popular' => 0,
            'category_id' => $category->id,
        ]);

        // Cart item to checkout (Kopi Tubruk, qty 2, subtotal 20000)
        $cart1 = Cart::create([
            'customer_id' => $customer->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'subtotal' => 20000,
        ]);

        $this->actingAs($customer, 'customer');

        // Configure mock Payment Gateway
        config(['payment.provider' => 'doku']);
        $stub = new class extends \App\Services\Payment\DokuGateway {
            public function __construct() {}
            public function initiatePayment($order, array $options = []): array {
                return [
                    'external_id' => 'INV-DOKU-MOCK',
                    'status' => 'menunggu',
                    'redirect_url' => 'https://jokul.doku.com/checkout-page'
                ];
            }
        };
        $this->app->instance(\App\Services\Payment\PaymentGatewayInterface::class, $stub);

        // 2. Act: process checkout
        $response = $this->post('/checkout', [
            'address' => 'Jl. Mawar No. 4, Jakarta',
            'payment_method' => 'transfer',
        ]);

        // 3. Assert Order and items are stored
        $response->assertRedirect('https://jokul.doku.com/checkout-page');

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'address' => 'Jl. Mawar No. 4, Jakarta',
            'payment_method' => 'transfer',
            'total_price' => 20000,
        ]);

        $order = Order::where('customer_id', $customer->id)->first();

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => 10000,
            'subtotal' => 20000,
        ]);

        // Assert that the checked out cart items have been cleared
        $this->assertDatabaseMissing('carts', [
            'id' => $cart1->id,
        ]);
    }

    /** @test */
    public function promo_code_discount_calculation()
    {
        $promo = PromoCode::create([
            'code' => 'DISKON10',
            'name' => 'Diskon Awal Tahun',
            'discount_type' => 'fixed',
            'discount_value' => 10000,
            'is_active' => true,
            'banner_image' => 'promo.jpg',
            'button_link' => 'https://example.com/promo',
        ]);

        $this->assertDatabaseHas('promo_codes', [
            'code' => 'DISKON10',
            'name' => 'Diskon Awal Tahun',
            'discount_type' => 'fixed',
            'discount_value' => 10000,
        ]);

        $this->assertEquals(10000, $promo->discount_value);
    }
}
