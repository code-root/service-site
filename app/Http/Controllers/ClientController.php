<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('program')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('clients.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'program_id' => 'required|exists:programs,id',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
                         ->with('success', 'Client created successfully.');
    }

    // Other methods like show, edit, update, destroy...
}
