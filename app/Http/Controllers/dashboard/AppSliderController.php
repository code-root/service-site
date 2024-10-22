<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\App\AppSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppSliderController extends Controller
{



    public function api()
    {
        return AppSlider::where('status', 1)->get();
    }


    // AppVersion::orderBy('id', 'desc')->first();
    public function getData(Request $request)
    {
        $class_model =  new AppSlider();
        $query = AppSlider::query();
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


    public function index()
    {


        return view('dashboard.AppSlider.index')->with('data', AppSlider::get());
    }


    public function uploaded()
    {
        return view('dashboard.excel.category');
    }




    public function edit($id)
    {
        $data = AppSlider::where('id', $id)->first();
        return view('dashboard.AppSlider.edit', compact('data'));
    }



    public function update(Request $request)
    {
        $appSlider = AppSlider::findOrFail($request->id);
        $data = $request->only(['name_ar', 'name_en', 'details', 'status']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('AppSlider');
            $data['image'] = $imagePath;
        }
        $appSlider->update($data);
        return back()->with('success', 'AppSlider' . ' updated successfully');
    }



    public function toggleStatus(Request $request)
    {
        $item = AppSlider::where('id', $request->id)->first();
        $item->status = $item->status == 1 ? 0 : 1;
        $item->save();
        return response()->json(['success' => true]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $data = $request->only(['name_ar', 'name_en', 'details', 'status']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('AppSlider');
            $data['image'] = $imagePath;
        }

        $item = AppSlider::create($data);

        return response()->json(['message' => 'Added AppSlider successfully', 'data' => $item]);
    }



    public function destroy(Request $request)
    {
        $appSlider = AppSlider::findOrFail($request->id);
        $appSlider->delete();
        return response()->json(['message' => 'AppSlider deleted successfully']);
    }
}
