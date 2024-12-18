<?php 

namespace App\Providers;

use App\Http\Controllers\dashboard\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\App\Page;
use App\Models\Language;
use App\Models\Section;
use App\Models\site\Category;
use App\Models\site\Service;

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
            $sections = Section::get();
            $category = Category::get();
            $view->with('basicFields', $basicFields);
            $view->with('settings', $settings);
            $view->with('languages', $languages);
            $view->with('locale', $locale);
            $view->with('sections', $sections);
            $view->with('category', $category);
            

        });



        view()->composer('dashboard.layouts.navbar', function ($view) {
            $view->with('loginUser', Auth::user());
        });


    }

    private function shareSettingsAndBasicFields(string $viewName)
    {
        view()->composer($viewName, function ($view) {
            $locale = session('locale', 'ar');
            $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
            $basicFields = Setting::where('type', null)->pluck('value', 'slug')->toArray();
            $view->with('basicFields', $basicFields);
            $view->with('settings', $settings);
            $view->with('locale', $locale);
        });
    }
}