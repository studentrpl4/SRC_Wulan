<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;

class FrontService
{
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository,
    CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function searchProduct(string $keyword)
    {
        return $this->productRepository->searchByName($keyword);
    }

    public function searchProducts(string $keyword)
    {
        return $this->productRepository->searchByName($keyword);
    }

    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $popularProducts = $this->productRepository->getPopularProducts(4);
        $newProducts = $this->productRepository->getAllNewProducts(10);

        $promoModels = PromoCode::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->latest('id')
            ->take(5)
            ->get();

        $promoBanners = $promoModels->map(function ($promo) {
            $discountBadge = null;

            if ($promo->discount_value && in_array(strtolower($promo->discount_type), ['percentage', 'percent'])) {
                $discountBadge = intval($promo->discount_value) . '% OFF';
            } elseif ($promo->discount_value && in_array(strtolower($promo->discount_type), ['amount', 'fixed'])) {
                $discountBadge = 'DISKON ' . number_format($promo->discount_value, 0, '.', '.');
            } elseif ($promo->discount_value && is_numeric($promo->discount_value)) {
                $discountBadge = intval($promo->discount_value) . '% OFF';
            } elseif ($promo->code) {
                $discountBadge = strtoupper($promo->code);
            }

            return (object) [
                'banner_image' => $promo->banner_image ? asset('storage/' . $promo->banner_image) : null,
                'title' => $promo->name ?: 'Promo Spesial SRC Wulan',
                'description' => $promo->description ?: 'Temukan penawaran menarik setiap hari di SRC Wulan.',
                'discount_badge' => $discountBadge,
                'button_link' => $promo->button_link ?: route('front.index'),
            ];
        })->toArray();

        $promo = isset($promoBanners[0]) ? (object) $promoBanners[0] : null;

        return compact('categories', 'popularProducts', 'newProducts', 'promo', 'promoBanners');
    }
}