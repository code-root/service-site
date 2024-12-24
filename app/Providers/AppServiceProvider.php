<?php

namespace App\Providers;

use App\Models\App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Section;
use App\Models\Service;
use App\Models\site\Category;
use App\Models\Testimonial;

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

        // توفير اللغة في جميع الصفحات
        view()->composer('*', function ($view) {
            $locale = session('locale', 'ar');
            $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
            $basicFields = Setting::where('type', 'basic')->pluck('value', 'slug')->toArray();
            $languages = Language::get();
            $pages = Page::get();
            $sections = Section::get();
            $categories = Category::with('services')->get();
            $view->with('categories', $categories);
            $view->with('basicFields', $basicFields);
            $view->with('settings', $settings);
            $view->with('languages', $languages);
            $view->with('locale', $locale);
            $view->with('sections', $sections);
            $view->with('pages', $pages);
        });

        view()->composer('dashboard.layouts.navbar', function ($view) {
            $view->with('loginUser', Auth::user());
        });
        
        view()->composer('site.components.say-about', function ($view) {
            $view->with('testimonials', Testimonial::all());
        });

        view()->composer('site.components.services', function ($view) {
            $services = Service::with('orders', 'views')->get();
            $view->with('services', $services);
        });

        $this->shareSettingsAndBasicFields('dashboard.layouts.navbar');
    }

    private function shareSettingsAndBasicFields(string $viewName)
    {
        view()->composer($viewName, function ($view) {
            $locale = session('locale', 'ar');
            $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
            $basicFields = Setting::where('type', null)->pluck('value', 'slug')->toArray();
            $languages = Language::all();
            $sections = Section::get();
            $category = Category::get();
            $view->with('basicFields', $basicFields);
            $view->with('settings', $settings);
            $view->with('languages', $languages);
            $view->with('locale', $locale);
            $view->with('sections', $sections);
            $view->with('category', $category);
        });
    }
}
