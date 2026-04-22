<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk
        $products = Product::all();

        foreach ($products as $product) {
            // Buat 3 foto per produk
            ProductPhoto::factory()->count(3)->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
