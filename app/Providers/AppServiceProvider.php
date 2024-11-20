<?php 

namespace App\Providers;

use App\Http\Controllers\dashboard\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\App\Page;
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

        // توفير اللغة في جميع الصفحات
        view()->composer('*', function ($view) {
            $locale = session('locale', 'ar');
            $view->with('locale', $locale);
        });


        $this->shareSettingsAndBasicFields('site.layouts.app');
        $this->shareSettingsAndBasicFields('site.layouts.navbar');
        $this->shareSettingsAndBasicFields('site.partials.home-page.top-bar');
        $this->shareSettingsAndBasicFields('site.partials.home-page.about-us');
        $this->shareSettingsAndBasicFields('site.pages.contact');
        
        $this->shareSettingsAndBasicFields('dashboard.auth.login');
        $this->shareSettingsAndBasicFields('dashboard.auth.login');

        view()->composer('dashboard.layouts.navbar', function ($view) {
            $view->with('loginUser', Auth::user());
        });

        view()->composer('site.layouts.footer', function ($view) {
            $basicFields = Setting::where('type', null)->pluck('value', 'slug')->toArray();
            $pages = Page::where('status' , 'site')->limit(6)->latest()->get();
            $view->with('pages', $pages);
            $view->with('settings', $basicFields);
            
        });

        view()->composer('site.layouts.navbar', function ($view) {
            $pages = Page::where('status' , 'site')->latest()->get();
            $sections = Section::with('pages')->latest()->get();
            $view->with('pages', $pages);
            $view->with('sections', $sections);
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