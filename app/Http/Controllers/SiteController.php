<?php

namespace App\Http\Controllers;

use App\Models\App\AppSlider;
use App\Models\App\Page;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Faq;
use App\Models\SuccessPartner;

class SiteController extends Controller
{

    public function setLocale($locale)
    {
        // تحقق من أن اللغة المدخلة صحيحة
        if (in_array($locale, ['ar', 'en'])) {
            session(['locale' => $locale]); // تخزين اللغة في الجلسة
        }
        return redirect()->back(); // إعادة توجيه المستخدم إلى الصفحة السابقة
    }

    public function home()
    {
        $locale = session('locale', 'ar'); 
        $settings = Setting::where('type' , $locale)->pluck('value', 'slug')->toArray();
        $sliders = AppSlider::where('status' , 1)->get();
        $categories = Category::with('galleries')->where('status' , 1)->get();
        $faqs = Faq::all();
        $partners = SuccessPartner::get(); 
        $pages = Page::all();
        return view('site.home', compact('settings', 'sliders', 'categories', 'faqs', 'partners', 'pages'));
    }
}
