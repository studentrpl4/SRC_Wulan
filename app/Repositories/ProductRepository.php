<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

// class ProductRepository implements ProductRepositoryInterface
class ProductRepository implements ProductRepositoryInterface
{
    public function getPopularProducts($limit = 4)
    {
        return Product::where('is_popular', true)->take($limit)->get();
    }

    public function searchByName(string $keyword)
    {
        return Product::where('name', 'LIKE', '%' . $keyword . '%')->get();
    }

    public function getAllNewProducts()
    {
        return Product::latest()->get();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function getPrice($productId)
    {
        $product = $this->find($productId);
        return $product ? $product->price : 0;
    }
}
