<?php

namespace App\Http\Controllers;

use App\Models\App\AppSlider;
use App\Models\App\Page;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Faq;
use App\Models\SuccessPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{

    public function setLocale($locale)
    {

        if (in_array($locale, ['ar', 'en'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }

    public function home()
    {
        $locale = session('locale', 'ar');
        $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
        $sliders = AppSlider::where('status', 1)->get();
        $categories = Category::with('galleries')->where('status', 1)->get();
        $faqs = Faq::all();
        $partners = SuccessPartner::get();
        $pages = Page::where('status', 'site')->get();
        return view('site.home', compact('settings', 'sliders', 'categories', 'faqs', 'partners', 'pages'));
    }

    public function viewImage(Request $request, $modelName)
    {
        try {
            if (empty($request->nameVar)) {
                throw new \Exception('Image variable not specified');
            } else {
                $nameVar = $request->nameVar;
            }


            if ($modelName == 'Setting') {
                $model = Setting::where('slug', $nameVar)->first();

                $imagePath = $model->value;
            } else {
                if (!class_exists($modelName)) {
                    throw new \Exception('Model not found');
                }
                $model = resolve($modelName);

                // تحميل النموذج ديناميكيًا

                // البحث عن السجل باستخدام المعرف
                $record = $model::find($request->id);
                if (!$record) {
                    throw new \Exception('Record not found');
                }

                $imagePath = $record->$nameVar;
                if (!Storage::exists($imagePath)) {
                    throw new \Exception('Image not found');
                }
            }



            // عرض الصورة
            return response()->file(storage_path('app/' . $imagePath), [
                'Content-Type' => Storage::mimeType($imagePath),
                'Content-Disposition' => 'inline',
            ]);
        } catch (\Exception $e) {
            // عرض الصورة الافتراضية في حالة حدوث خطأ
            return response()->file(storage_path('app/default_large.png'), [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline',
            ]);
        }
    }
}
