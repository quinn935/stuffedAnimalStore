<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.navigation', function ($view) {
            $categories = Category::where(['active'=>1, 'parent_id'=>null])->get();
            // $animals= Category::where(['active'=>1, 'parent_id'])->get();
            $view->with('categories', $categories);
        });
    }
}
