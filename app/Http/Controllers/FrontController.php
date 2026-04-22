<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\FrontService;

class FrontController extends Controller
{
    //
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = $this->frontService->searchProducts($keyword);

        return view('front.search', ['products' => $products, 'keyword' => $keyword,]);
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);
    }

    public function details(Product $product)
    {
        $category = $product->category;
        return view('front.details', compact('product', 'category'));
    }
    public function produk(Product $product)
    {
        $data = $this->frontService->getFrontPageData();
        $populerproduk = Product::where('is_popular', 'like', 1)->latest()->get();
        // dd($populerproduk);
        return view('front.produk', $data, compact('populerproduk'));
    }
    public function allcategory(Product $product)
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.allcategory', $data);
    }

    public function category(Category $category)
    {
        return view('front.category', compact('category'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Jika produk sudah ada di keranjang → update qty
        $cart = Cart::where('customer_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->subtotal = $cart->quantity * $product->price;
            $cart->save();
        } else {
            Cart::create([
                'customer_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function order_success()
    {
        $cart = Cart::where('customer_id', auth()->id())
            ->first();
        if(empty($cart)){
            return redirect()->route('front.index')->with('error','tidak ada produk yang dibeli');
        }
        $cart->delete();
        return view('front.orders.ordersukses',compact('cart'));
    }

    public function cart()
    {
        $carts = Cart::where('customer_id', auth('customer')->id())
            ->with('product.category')
            ->get();

        $total = $carts->sum('subtotal');

        return view('front.cart', compact('carts', 'total'));
    }
}
