<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPhoto>
 */
class ProductPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'photo' => 'products/' . $this->faker->image('storage/app/public/products', 640, 480, null, false),
            'product_id' => \App\Models\Product::factory(), // otomatis membuat produk jika belum ada
        ];
    }
}
