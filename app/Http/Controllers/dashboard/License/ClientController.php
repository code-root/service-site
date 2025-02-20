<?php

namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function index()
    {
    if (Auth::user()->hasRole('admin')) {
    // User has admin role, retrieve all clients
    $clients = Client::all();
    } else {
    // Retrieve clients that belong to the current user
    $clients = Client::where('user_id', Auth::id())->get();
    }

    return view('dashboard.clients.index', compact('clients'));
    }
    
    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('dashboard.clients.edit', compact('client'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'required|string|max:15',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('client_images', 'public');
        }

        $licenseData['user_id'] = Auth::user()->id;
        Client::create($data);

        return redirect()->route('clients.index')
                         ->with('success', 'Client created successfully.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $request->client_id,
            'phone' => 'required|string|max:15',
            'location' => 'nullable|string|max:255',
        ]);

        $client = Client::find($request->client_id);
        $client->update($validated);

        return response()->json(['success' => 'Client updated successfully']);
    }

    public function destroy(Client $client)
    {
        if ($client->profile_image) {
            Storage::disk('public')->delete($client->profile_image);
        }
        $client->delete();

        return [
            'success' => true,
            'message' => 'Client deleted successfully',
        ];
    }

    public function show($id)
    {
        $clients = Client::select(['id', 'name', 'email', 'phone', 'location']);

        return datatables()->of($clients)
            ->addColumn('status', function ($client) {
                return $client->status ? 'Active' : 'Inactive'; // Display status as 'Active' or 'Inactive'
            })
            ->make(true);
    }

    public function getData()
    {
        $clients = Client::select(['id', 'name', 'email', 'phone', 'location']);

        return datatables()->of($clients)
            ->addColumn('status', function ($client) {
                return $client->status ? 'Active' : 'Inactive'; // Display status as 'Active' or 'Inactive'
            })
            ->make(true);
    }


}
