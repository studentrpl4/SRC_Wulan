<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed data kategori produk minimarket.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan Ringan',
                'icon' => 'icon-snack.png',
            ],
            [
                'name' => 'Minuman',
                'icon' => 'icon-minuman.png',
            ],
            [
                'name' => 'Makanan Instan',
                'icon' => 'icon-instan.png',
            ],
            [
                'name' => 'Kebutuhan Rumah Tangga',
                'icon' => 'icon-rumah-tangga.png',
            ],
            [
                'name' => 'Perawatan Tubuh',
                'icon' => 'icon-perawatan.png',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
