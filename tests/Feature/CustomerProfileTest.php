<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.defaults.guard' => 'customer']);
    }

    /** @test */
    public function shows_profile_setup_page_if_incomplete()
    {
        $customer = Customer::create([
            'email' => 'setup@mail.com',
            'password' => 'secret123',
            'profile_completed' => false,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->get('/setup-profile');
        $response->assertStatus(200);
        $response->assertViewIs('customer.setup-profile');
    }

    /** @test */
    public function can_store_profile_setup()
    {
        $customer = Customer::create([
            'email' => 'setup@mail.com',
            'password' => 'secret123',
            'profile_completed' => false,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post('/setup-profile', [
            'name' => 'Wulan Suci',
            'phone' => '08123456789',
            'gender' => 'perempuan',
            'birth_date' => '2001-10-12',
        ]);

        $response->assertRedirect(route('front.index'));
        
        $customer->refresh();
        $this->assertEquals('Wulan Suci', $customer->name);
        $this->assertEquals('08123456789', $customer->phone);
        $this->assertEquals('perempuan', $customer->gender);
        $this->assertTrue($customer->profile_completed);
    }

    /** @test */
    public function shows_profile_detail_and_dashboard()
    {
        $customer = Customer::create([
            'email' => 'detail@mail.com',
            'password' => 'secret123',
            'name' => 'Wulan Suci',
            'phone' => '08123456789',
            'gender' => 'perempuan',
            'birth_date' => '2001-10-12',
            'profile_completed' => true,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->get('/datail-profile');
        $response->assertStatus(200);
        $response->assertViewIs('customer.detailprofile');
    }

    /** @test */
    public function can_update_profile()
    {
        $customer = Customer::create([
            'email' => 'update@mail.com',
            'password' => 'secret123',
            'name' => 'Old Name',
            'phone' => '000000',
            'gender' => 'laki-laki',
            'birth_date' => '1990-01-01',
            'profile_completed' => true,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->put('/profile', [
            'name' => 'New Name',
            'phone' => '111111',
            'gender' => 'perempuan',
            'birth_date' => '1995-05-05',
        ]);

        $response->assertRedirect(route('customer.profile'));
        
        $customer->refresh();
        $this->assertEquals('New Name', $customer->name);
        $this->assertEquals('111111', $customer->phone);
    }
}
