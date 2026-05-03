<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Seed data pelanggan.
     */
    public function run(): void
    {
        $customers = [
            [
                'email'             => 'budi.santoso@gmail.com',
                'password'          => 'password123',
                'name'              => 'Budi Santoso',
                'phone'             => '081234567890',
                'gender'            => 'male',
                'birth_date'        => '1995-06-10',
                'profile_completed' => true,
            ],
            [
                'email'             => 'dewi.lestari@gmail.com',
                'password'          => 'password123',
                'name'              => 'Dewi Lestari',
                'phone'             => '082345678901',
                'gender'            => 'female',
                'birth_date'        => '1998-03-22',
                'profile_completed' => true,
            ],
            [
                'email'             => 'andi.pratama@gmail.com',
                'password'          => 'password123',
                'name'              => 'Andi Pratama',
                'phone'             => '083456789012',
                'gender'            => 'male',
                'birth_date'        => '2000-11-05',
                'profile_completed' => true,
            ],
            [
                'email'             => 'sari.wulandari@gmail.com',
                'password'          => 'password123',
                'name'              => 'Sari Wulandari',
                'phone'             => '084567890123',
                'gender'            => 'female',
                'birth_date'        => '1997-08-17',
                'profile_completed' => true,
            ],
            [
                'email'             => 'rizky.ramadhan@gmail.com',
                'password'          => 'password123',
                'name'              => 'Rizky Ramadhan',
                'phone'             => '085678901234',
                'gender'            => 'male',
                'birth_date'        => '2001-01-30',
                'profile_completed' => false,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
