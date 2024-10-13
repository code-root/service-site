<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{
    public function index()
    {
        return view('dashboard.faq.index');
    }

    public function data(Request $request)
    {
   
            if ($request->ajax()) {
                $data = Faq::all();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
    }

    public function create(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create($request->all());

        return response()->json(['success' => 'FAQ added successfully.']);
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return response()->json($faq);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return response()->json(['success' => 'FAQ updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $faq = Faq::findOrFail($request->id);
        $faq->delete();

        return response()->json(['success' => 'FAQ deleted successfully.']);
    }
}
