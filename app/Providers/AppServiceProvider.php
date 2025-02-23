<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $categories = Category::withCount('products')->get();
            $descriptions = Product::all();
            $suppliers = Product::select('supplier_name')
                ->distinct()
                ->groupBy('supplier_name')
                ->get();

            $view->with(compact('categories', 'descriptions', 'suppliers'));
        });
    }
}
