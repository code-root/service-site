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
    public function home()
    {
        $settings = Setting::pluck('value', 'slug')->toArray();
        $sliders = AppSlider::where('status' , 1)->get();
        $categories = Category::with('galleries')->where('status' , 1)->get();
        $faqs = Faq::all();
        $partners = SuccessPartner::get(); 
        $pages = Page::all();
        return view('site.home', compact('settings', 'sliders', 'categories', 'faqs', 'partners', 'pages'));
    }
}
