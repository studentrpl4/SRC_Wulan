<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    /**
     * Get front page data (popular products, new products, categories).
     */
    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return response()->json($data);
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = $this->frontService->searchProducts($keyword);

        return response()->json([
            'keyword' => $keyword,
            'products' => $products
        ]);
    }

    /**
     * Get product details.
     */
    public function details(Product $product)
    {
        $category = $product->category;
        return response()->json([
            'product' => $product,
            'category' => $category
        ]);
    }

    /**
     * Get products by category.
     */
    public function category(Category $category)
    {
        $category->load('products');
        return response()->json([
            'category' => $category
        ]);
    }

    public function allcategory()
    {
        $data = $this->frontService->getFrontPageData();
        // Assuming we just want categories from the service data or fetch all
        // The service returns 'categories' in the array
        return response()->json([
            'categories' => $data['categories']
        ]);
    }

    public function produk()
    {
         $populerproduk = Product::where('is_popular', 'like', 1)->latest()->get();
         $products = Product::latest()->get(); // Assuming we want all products
         
         return response()->json([
             'popular_products' => $populerproduk,
             'products' => $products
         ]);
    }
}
