<?php

namespace App\Providers;

use App\Models\App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Section;

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
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $locale = session('locale', 'ar');
            $view->with('locale', $locale);
        });
        view()->composer('dashboard.layouts.navbar', function ($view) {
            $view->with('loginUser', Auth::user());
        });
        
  

    }

}
