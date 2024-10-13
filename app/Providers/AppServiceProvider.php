<?php

namespace App\Providers;

use App\Http\Controllers\dashboard\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

use App\Models\App\Page;

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
        view()->composer('dashboard.layouts.navbar',
        function ($view) {
            $adminController = new AdminController();
            $view->with('loginUser', Auth::user());
        });
        
        view()->composer('home.layouts.footer',
        function ($view) {
            $pages = Page::all();
            $view->with('pages', $pages);
        });
        view()->composer('site.layouts.navbar',
        function ($view) {
            $pages = Page::all();
            $view->with('pages', $pages);
        });

        view()->composer('site.layouts.app',
        function ($view) {
            $settings = Setting::pluck('value', 'slug')->toArray();
            $view->with('settings', $settings);
        });

        view()->composer('site.pages.contact',
        function ($view) {
            $settings = Setting::pluck('value', 'slug')->toArray();
            $view->with('settings', $settings);
        });

        view()->composer('dashboard.auth.login',
        function ($view) {
            $settings = Setting::pluck('value', 'slug')->toArray();
            $view->with('settings', $settings);
        });
        
    }


}
