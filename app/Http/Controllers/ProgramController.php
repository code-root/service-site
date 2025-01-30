<?php
namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'activation_code' => 'required|unique:programs',
            'price' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        Program::create($request->all());

        return redirect()->route('programs.index')
                         ->with('success', 'Program created successfully.');
    }

    // Other methods like show, edit, update, destroy...
}
