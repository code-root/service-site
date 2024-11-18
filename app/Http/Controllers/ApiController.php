<?php

namespace App\Http\Controllers;

use App\Models\App\AppSlider;
use App\Models\App\Page;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Contact;
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
        $socials = Setting::whereIn('slug', ['facebook', 'instagram', 'linkedin', 'twitter'])->pluck('value', 'slug')->toArray();
        $socials['google_maps'] = $settings['google_maps'] ??  '';
        $socials['x'] = $settings['x'] ??  '';
        
        $sliders = AppSlider::select(['id', 'name_'.$locale.' AS name', 'details_'.$locale.' AS details' , 'image'])->where('status', 1)->get();
        $pages = Page::select(['id', 'name_'.$locale.' AS name', 'description_'.$locale.' AS description' ,'meta_'.$locale.' AS meta'])->where('status', 'site')->get();
        $categories = Category::select(['id', 'name_'.$locale.' AS name', 'description_'.$locale.' AS description','image','status'])->with(['galleries' => function($q) use ($locale){
            $q->select(['id', 'category_id', 'image','page_id']);
        }])->where('status', 1)->get();

        $faqs = Faq::select(['id', 'question_'.$locale.' AS question', 'answer_'.$locale.' AS answer'])->get();
        $sections = Section::select(['id', 'name_'.$locale.' AS name', 'description_'.$locale.' AS description'])->with(['pages' => function($q) use ($locale){
            $q->select(['id', 'section_id', 'name_'.$locale.' AS name']);
        }])->where('sections.status', 1)->get();
     
        $partners = SuccessPartner::select(['id', 'name', 'logo'])->get();
        return response()->json([
            'settings' => $settings,
            'socials' => $socials,
            'sliders' => $sliders,
            'pages' => $pages,
            'categories' => $categories,
            'faqs' => $faqs,
            'sections' => $sections,
            'partners' => $partners,
        ]);
    }

    public function categories($locale = 'ar')
    {
     
        $categories = Category::select(['id', 'name_'.$locale.' AS name', 'description_'.$locale.' AS description','image','status'])->with(['galleries' => function($q) use ($locale){
            $q->select(['id', 'category_id', 'image','page_id']);
        }])->where('status', 1)->get();

        $faqs = Faq::select(['id', 'question_'.$locale.' AS question', 'answer_'.$locale.' AS answer'])->get();
        $sections = Section::select(['id', 'name_'.$locale.' AS name', 'description_'.$locale.' AS description'])->with(['pages' => function($q) use ($locale){
            $q->select(['id', 'section_id', 'name_'.$locale.' AS name']);
        }])->where('sections.status', 1)->get();
     
        $partners = SuccessPartner::select(['id', 'name', 'logo'])->get();
        return response()->json([
            'categories' => $categories,
            'faqs' => $faqs,
            'sections' => $sections,
            'partners' => $partners,
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

    public function ContactStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'contact-name' => 'required|string|max:255',
                'contact-email' => 'required|email|max:255',
                'contact-phone' => 'nullable|string|max:20',
                'contact-message' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    
        Contact::create([
            'name' => $validatedData['contact-name'],
            'email' => $validatedData['contact-email'],
            'phone' => $validatedData['contact-phone'],
            'message' => $validatedData['contact-message'],
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent successfully.'
        ]);
    }
}
