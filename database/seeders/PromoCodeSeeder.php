<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    public function run(): void
    {
        $promoCodes = [
            [
                'code' => 'HEMATBELANJA', 'name' => 'Hemat Belanja Mingguan',
                'description' => 'Diskon 10% untuk belanja mingguan. Maks potongan Rp 15.000.',
                'discount_type' => 'percentage', 'discount_value' => 10,
                'min_purchase' => 50000, 'max_discount' => 15000,
                'usage_limit' => 200, 'usage_count' => 0, 'usage_limit_per_user' => 2,
                'is_active' => true, 'start_date' => now(), 'end_date' => now()->addMonths(3),
            ],
            [
                'code' => 'GRATISONGKIR', 'name' => 'Gratis Ongkir',
                'description' => 'Potongan Rp 10.000 untuk ongkir. Min belanja Rp 30.000.',
                'discount_type' => 'fixed', 'discount_value' => 10000,
                'min_purchase' => 30000, 'max_discount' => null,
                'usage_limit' => 500, 'usage_count' => 0, 'usage_limit_per_user' => 3,
                'is_active' => true, 'start_date' => now(), 'end_date' => now()->addMonths(1),
            ],
            [
                'code' => 'MEMBER15', 'name' => 'Diskon Member Baru',
                'description' => 'Diskon 15% khusus member baru. Maks potongan Rp 25.000.',
                'discount_type' => 'percentage', 'discount_value' => 15,
                'min_purchase' => 75000, 'max_discount' => 25000,
                'usage_limit' => 100, 'usage_count' => 0, 'usage_limit_per_user' => 1,
                'is_active' => true, 'start_date' => now(), 'end_date' => now()->addMonths(6),
            ],
            [
                'code' => 'WEEKEND20', 'name' => 'Promo Weekend',
                'description' => 'Diskon 20% khusus akhir pekan. Maks potongan Rp 30.000.',
                'discount_type' => 'percentage', 'discount_value' => 20,
                'min_purchase' => 100000, 'max_discount' => 30000,
                'usage_limit' => 50, 'usage_count' => 12, 'usage_limit_per_user' => 1,
                'is_active' => true, 'start_date' => now()->subWeeks(2), 'end_date' => now()->addWeeks(2),
            ],
            [
                'code' => 'PROMOLEBARAN', 'name' => 'Promo Lebaran',
                'description' => 'Promo spesial lebaran yang sudah berakhir.',
                'discount_type' => 'percentage', 'discount_value' => 25,
                'min_purchase' => 50000, 'max_discount' => 50000,
                'usage_limit' => 100, 'usage_count' => 87, 'usage_limit_per_user' => 1,
                'is_active' => false, 'start_date' => now()->subMonths(3), 'end_date' => now()->subMonth(),
            ],
        ];

        foreach ($promoCodes as $promo) {
            PromoCode::create($promo);
        }
    }
}
