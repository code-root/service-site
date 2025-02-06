<?php
namespace App\Http\Controllers\dashboard\site;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('dashboard.testimonials.index');
    }

    public function data()
    {
        $testimonials = Testimonial::all();
        return DataTables::of($testimonials)
            ->addColumn('action', function ($testimonial) {
                return '
                    <a href="#" class="dropdown-item edit-testimonial" data-id="' . $testimonial->id . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="#" class="dropdown-item delete-testimonial" data-id="' . $testimonial->id . '">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                ';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'testimonial' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('testimonials', 'public');

        Testimonial::create([
            'name' => $request->name,
            'position' => $request->position,
            'testimonial' => $request->testimonial,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => 'Testimonial added successfully.']);
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return response()->json($testimonial);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'testimonial' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $testimonial = Testimonial::find($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $testimonial->image = $imagePath;
        }

        $testimonial->update([
            'name' => $request->name,
            'position' => $request->position,
            'testimonial' => $request->testimonial,
        ]);

        return response()->json(['success' => 'Testimonial updated successfully.']);
    }

    public function destroy($id)
    {
        Testimonial::find($id)->delete();
        return response()->json(['success' => 'Testimonial deleted successfully.']);
    }
}
