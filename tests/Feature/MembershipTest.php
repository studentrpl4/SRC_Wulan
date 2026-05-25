<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\MemberPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_apply_for_membership()
    {
        $customer = Customer::create([
            'email' => 'customer@test.com',
            'password' => 'password123',
            'name' => 'John Member',
            'phone' => '081234567890',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'profile_completed' => true,
        ]);

        $membership = Membership::create([
            'user_id' => $customer->id, // user_id is the foreign key to customers
            'ktp_photo' => 'ktp-photos/test_ktp.webp',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('member_points', [ // table for Membership applications is member_points
            'user_id' => $customer->id,
            'ktp_photo' => 'ktp-photos/test_ktp.webp',
            'status' => 'pending',
        ]);

        $this->assertTrue($customer->membership->is($membership));
        $this->assertFalse($customer->isMember());
    }

    /** @test */
    public function is_member_returns_true_when_status_is_active()
    {
        $customer = Customer::create([
            'email' => 'customer@test.com',
            'password' => 'password123',
            'name' => 'Active Member',
            'phone' => '081234567890',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'profile_completed' => true,
        ]);

        $membership = Membership::create([
            'user_id' => $customer->id,
            'ktp_photo' => 'ktp-photos/test_ktp.webp',
            'status' => 'active',
        ]);

        $this->assertTrue($customer->isMember());
    }

    /** @test */
    public function customer_available_points_are_correctly_calculated()
    {
        $customer = Customer::create([
            'email' => 'customer@test.com',
            'password' => 'password123',
            'name' => 'Points earner',
            'phone' => '081234567890',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'profile_completed' => true,
        ]);

        // Create point transactions (mapped to memberships table)
        // Earned 100 points
        MemberPoint::create([
            'user_id' => $customer->id,
            'points' => 100,
            'type' => 'earned',
            'expired_at' => now()->addDays(30),
        ]);

        // Earned 50 points
        MemberPoint::create([
            'user_id' => $customer->id,
            'points' => 50,
            'type' => 'earned',
            'expired_at' => now()->addDays(30),
        ]);

        // Redeemed 30 points (value will be negative or stored positive but we sum)
        // Wait, look at availablePoints logic:
        // sum('points') of earned + sum('points') of redeemed/voided/expired.
        // Wait, redeemed points are stored as negative values? Or positive values?
        // Let's check: in availablePoints:
        // + $this->points()->whereIn('type', ['redeemed', 'voided', 'expired'])->sum('points');
        // If it uses '+', then redeemed points must be stored as negative numbers (e.g. -30) in the DB to subtract!
        // Yes, the comment in the migration 2026_05_05_034308_create_memberships_table.php says:
        // $table->integer('points'); // positif = dapat poin, negatif = pakai/hangus
        // That's brilliant! So redeemed points are stored as negative numbers! E.g. -30.
        MemberPoint::create([
            'user_id' => $customer->id,
            'points' => -30,
            'type' => 'redeemed',
            'expired_at' => now()->addDays(30),
        ]);

        // Expired point (should not be counted in earned, but wait, the earned scope checks where('expired_at', '>', now()))
        // So a points record with expired_at in the past won't be summed in earned because of 'expired_at > now()' condition!
        MemberPoint::create([
            'user_id' => $customer->id,
            'points' => 200,
            'type' => 'earned',
            'expired_at' => now()->subDays(1),
        ]);

        // Total available points: 100 + 50 + (-30) = 120
        $this->assertEquals(120, $customer->availablePoints());
    }
}
