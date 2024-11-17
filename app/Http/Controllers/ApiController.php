<?php

namespace App\Http\Controllers;

use App\Models\App\AppSlider;
use App\Models\App\Page;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Section;
use App\Models\SuccessPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{


    public function home($locale = 'ar')
    {
        $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
        $sliders = AppSlider::where('status', 1)->get();
        $categories = Category::with('galleries')->where('status', 1)->get();
        $faqs = Faq::all();
        $sections = Section::with('pages')->get();
        $partners = SuccessPartner::get();
        $pages = Page::where('status', 'site')->get();
        return response()->json([
            'settings' => $settings,
            'sliders' => $sliders,
            'categories' => $categories,
            'faqs' => $faqs,
            'sections' => $sections,
            'partners' => $partners,
            'pages' => $pages,
        ]);
    }

    public function showPage($id)
    {

        $page = Page::findOrFail($id);
        return response()->json($page);
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
