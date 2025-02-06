<?php

namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;

use App\Models\Program;
use App\Models\site\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('dashboard.programs.index', compact('programs'));
    }

    public function create()
    {
        $categories =Category::all(); // Fetch all categories
        return view('dashboard.programs.create', compact('categories'));
    }

    public function edit($id)
    {
        $program = Program::find($id);
        $categories = Category::all(); // Fetch all categories
        return view('dashboard.programs.edit', compact('program', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('program_images', 'public');
        }

        Program::create($data);

        return redirect()->route('program.index')
                         ->with('success', 'Program created successfully.');
    }



    public function update(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

       $program =Program::find($request->program_id);
        $program->update($validated);

        return response()->json(['success' => 'Program updated successfully']);
    }


    public function destroy(Program $program)
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        $program->delete();

        return redirect()->route('program.index')
                         ->with('success', 'Program deleted successfully.');
    }

    public function getData()
    {
        $programs = Program::with('category') // Ensure that the 'category' relationship is loaded
            ->select(['id', 'name', 'category_id', 'description', 'status', 'price']);

        return datatables()->of($programs)
            ->addColumn('category', function ($program) {
                return $program->category ? $program->category->name : 'No Category'; // Return category name or 'No Category'
            })
            ->make(true);
    }


    public function toggleStatus($id)
    {
        $program = Program::findOrFail($id);
        $program->status = !$program->status;
        $program->save();

        return response()->json(['success' => 'Program status updated successfully.', 'status' => $program->status]);
    }
}
