<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class CustomerAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.defaults.guard' => 'customer']);
    }

    /** @test */
    public function shows_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('customer.auth.login');
    }

    /** @test */
    public function customer_can_login_successfully()
    {
        $customer = Customer::create([
            'email' => 'budii@mail.com',
            'password' => bcrypt('secret123'),
            'name' => 'Budi',
            'profile_completed' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'budii@mail.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('front.index'));
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    /** @test */
    public function login_redirects_to_profile_setup_if_incomplete()
    {
        $customer = Customer::create([
            'email' => 'incomplete@mail.com',
            'password' => bcrypt('secret123'),
            'name' => 'Budi',
            'profile_completed' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'incomplete@mail.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('customer.setupProfile'));
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        Customer::create([
            'email' => 'valid@mail.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'valid@mail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('customer');
    }

    /** @test */
    public function shows_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('customer.auth.register');
    }

    /** @test */
    public function customer_can_register_successfully()
    {
        $response = $this->post('/register', [
            'email' => 'new@mail.com',
            'password' => 'newsecret123',
            'password_confirmation' => 'newsecret123',
        ]);

        $this->assertDatabaseHas('customers', [
            'email' => 'new@mail.com',
        ]);

        $customer = Customer::where('email', 'new@mail.com')->first();
        $response->assertRedirect(route('customer.setupProfile'));
        $this->assertAuthenticatedAs($customer, 'customer');
    }

    /** @test */
    public function customer_can_logout()
    {
        $customer = Customer::create([
            'email' => 'logout@mail.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post('/logout');
        $response->assertRedirect(route('customer.auth.login'));
        $this->assertGuest('customer');
    }
}
