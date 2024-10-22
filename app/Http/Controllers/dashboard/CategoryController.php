<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.category.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'status' => 'required',
        ]);

        Category::create($request->all());

        return response()->json(['success' => 'تمت الإضافة بنجاح.']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return [
            'data' => $category,
        ];
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'status' => 'required',
        ]);

        $category->update($request->all());

        return response()->json(['success' => 'تم التحديث بنجاح.']);
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();

        return response()->json(['success' => 'تم الحذف بنجاح.']);
    }

    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $category->status == '1' ? '0' : '1';
        $category->save();

        return response()->json(['success' => 'تم تغيير الحالة بنجاح.']);
    }
}
