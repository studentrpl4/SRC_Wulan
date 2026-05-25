<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.defaults.guard' => 'customer']);
    }

    /** @test */
    public function customer_can_increase_cart_quantity()
    {
        $customer = Customer::create([
            'email' => 'cart@mail.com',
            'password' => 'secret123',
            'name' => 'Cart Owner',
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
            'quantity' => 1,
            'subtotal' => 15000,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->postJson("/cart/{$cart->id}/update-quantity", [
            'action' => 'increase',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'quantity' => 2,
            'subtotal' => '30.000',
        ]);

        $cart->refresh();
        $this->assertEquals(2, $cart->quantity);
        $this->assertEquals(30000, $cart->subtotal);
    }

    /** @test */
    public function customer_can_decrease_cart_quantity()
    {
        $customer = Customer::create([
            'email' => 'cart@mail.com',
            'password' => 'secret123',
            'name' => 'Cart Owner',
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
            'quantity' => 3,
            'subtotal' => 45000,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->postJson("/cart/{$cart->id}/update-quantity", [
            'action' => 'decrease',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'quantity' => 2,
            'subtotal' => '30.000',
        ]);

        $cart->refresh();
        $this->assertEquals(2, $cart->quantity);
        $this->assertEquals(30000, $cart->subtotal);
    }

    /** @test */
    public function unauthorized_customer_cannot_update_cart()
    {
        $owner = Customer::create(['email' => 'owner@mail.com', 'password' => 'secret123']);
        $thief = Customer::create(['email' => 'thief@mail.com', 'password' => 'secret123']);

        $category = Category::create(['name' => 'Snack', 'slug' => 'snack', 'icon' => 'snack.png']);
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
            'customer_id' => $owner->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'subtotal' => 15000,
        ]);

        $this->actingAs($thief, 'customer');

        $response = $this->postJson("/cart/{$cart->id}/update-quantity", [
            'action' => 'increase',
        ]);

        $response->assertStatus(403);
    }
}
