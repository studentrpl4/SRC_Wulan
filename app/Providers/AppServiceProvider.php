<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use Midtrans\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        // Initialize payment provider specific SDKs/configs only when needed.
        $provider = config('payment.provider', env('PAYMENT_PROVIDER', 'midtrans'));
        if ($provider === 'midtrans' && class_exists('\Midtrans\\Config')) {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;
        }
        // Bind PaymentGatewayInterface to the configured gateway implementation
        $this->app->singleton(\App\Services\Payment\PaymentGatewayInterface::class, function ($app) {
            $provider = config('payment.provider', env('PAYMENT_PROVIDER', 'midtrans'));
            if ($provider === 'doku') {
                return new \App\Services\Payment\DokuGateway();
            }
            // Fallback: if Midtrans or unknown, return null or a noop implementation later.
            return null;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
