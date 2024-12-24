<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\site\Slider;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; 

class SliderController extends Controller
{

    public function add() {
        return view('dashboard.Slider.add')
            ->with('token', Translation::generateUniqueToken())
            ->with('txt', Slider::txt()); 
    }


    public function api () {
       return Slider::where('status' , 1)->get();
    }


    // AppVersion::orderBy('id', 'desc')->first();
    public function getData(Request $request)
    {
        $class_model =  New Slider();
        $query = Slider::query();
        $fillable = $class_model->getFillable();
        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search, $fillable) {
                foreach ($fillable as $field) {
                    $q->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $data = $query->offset($request->start)->limit($request->length)->get();

        $json_data = [
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }


    public function index() {


        return view('dashboard.Slider.index')->with('data', Slider::get());
    }


    public function uploaded() {
        return view('dashboard.excel.category');
    }
    

    
    public function edit($id)
    {
        $data = Slider::with(['translations'])->findOrFail($id);
        $txt = Slider::txt(); // تأكد من استدعاء النصوص
        $languages = Translation::all(); // أو أي طريقة لجلب اللغات المتاحة
        return view('dashboard.Slider.edit', compact('data', 'txt', 'languages'));
    }



    
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('Slider', 'public');
            $slider->update(['image'=> 'app/'.$imagePath]);
                }
        // تحديث معلومات السلايدر
        $slider->update($request->only(['image', 'button_url', 'status']));
        // تحديث النصوص
       
    foreach ($request->except(['_token', '_method', 'image', 'button_url', 'status']) as $key => $translations) {
        // تأكد من أن $translations هو مصفوفة
        if (is_array($translations)) {
            foreach ($translations as $languageId => $value) {
                Translation::updateOrCreate(
                    [
                        'translatable_id' => $slider->id,
                        'translatable_type' => Slider::class,
                        'language_id' => $languageId,
                        'key' => $key,
                    ],
                    ['value' => $value, 'status' => 1]
                );
            }
        }
        }

        return redirect()->route('appSlider.index')->with('success', 'Slider updated successfully');
    }
    
    

    public function toggleStatus(Request $request) {
        $item = Slider::where('id', $request->id)->first();
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();
        return response()->json(['success' => true]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'button_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $token = $request->token ;

        $name = Translation::select('value')->where('key', 'name')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $description = Translation::select('value')->where('key', 'description')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $title = Translation::select('value')->where('key', 'title')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        $button_text = Translation::select('value')->where('key', 'button_text')->where('token', $token)->where('language_id', defaultLanguage())->first()['value'] ?? '';
        
        
        
     
        $data = $request->only(['name_ar', 'name_en', 'details', 'status', 'button_url']); 
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('Slider', 'public');
            $data['image'] =$imagePath;
        }

        $item = Slider::create([
            'image' => $data['image'] ,
            'name' =>$name,
            'description' =>$description,
            'title' =>$title,
            'button_text' =>$button_text,
            'tr_token'=>$token,
            'button_url'=>$request->button_url,
            'status'=>$request->status,
        ]);

        $button_text = Translation::where('token' , $token)->update([
            'translatable_id' => $item->id,
            'translatable_type' => Slider::class, 
        ]);

        return response()->json(['message' => 'Added Slider successfully', 'data' => $item]);
    }
    


    public function destroy(Request $request)
    {
        $Slider = Slider::findOrFail($request->id);
        $Slider->delete();
        return response()->json(['message' => 'Slider deleted successfully']);
    }


    public function getTranslations(Request $request)
    {
        $languageId = $request->input('language_id');
        $sliderId = $request->input('slider_id');

        $translations = Translation::where('language_id', $languageId)
            ->where('translatable_id', $sliderId)
            ->where('translatable_type', Slider::class)
            ->get();

        return response()->json($translations);
    }
}

