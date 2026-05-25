<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.defaults.guard' => 'customer']);
    }

    /** @test */
    public function storefront_landing_page_renders_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('front.index');
    }

    /** @test */
    public function search_products_by_keyword()
    {
        $category = Category::create(['name' => 'Snack', 'slug' => 'snack', 'icon' => 'snack.png']);
        $product = Product::create([
            'name' => 'Kripik Singkong Enak',
            'slug' => 'kripik-singkong-enak',
            'thumbnail' => 'kripik.jpg',
            'about' => 'Garing dan nikmat.',
            'price' => 15000,
            'stock' => 10,
            'is_popular' => 0,
            'category_id' => $category->id,
        ]);

        $response = $this->get('/search?keyword=Singkong');
        $response->assertStatus(200);
        $response->assertViewIs('front.search');
        $response->assertSee('Kripik Singkong Enak');
    }

    /** @test */
    public function view_product_detail_page()
    {
        $category = Category::create(['name' => 'Snack', 'slug' => 'snack', 'icon' => 'snack.png']);
        $product = Product::create([
            'name' => 'Kripik Singkong',
            'slug' => 'kripik-singkong',
            'thumbnail' => 'kripik.jpg',
            'about' => 'Garing.',
            'price' => 15000,
            'stock' => 10,
            'is_popular' => 0,
            'category_id' => $category->id,
        ]);

        ProductPhoto::create([
            'product_id' => $product->id,
            'photo' => 'product_photo.jpg',
        ]);

        $response = $this->get("/details/{$product->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('front.details');
        $response->assertSee('Kripik Singkong');
    }

    /** @test */
    public function customer_can_add_item_to_cart()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
        ]);

        $category = Category::create(['name' => 'Snack', 'slug' => 'snack', 'icon' => 'snack.png']);
        $product = Product::create([
            'name' => 'Kripik Singkong',
            'slug' => 'kripik-singkong',
            'thumbnail' => 'kripik.jpg',
            'about' => 'Garing.',
            'price' => 15000,
            'stock' => 10,
            'is_popular' => 0,
            'category_id' => $category->id,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('carts', [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'subtotal' => 30000,
        ]);
    }

    /** @test */
    public function view_cart_page()
    {
        $customer = Customer::create([
            'email' => 'buyer@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Sari',
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertViewIs('front.cart');
    }
}
