<?php

namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{


    public function sdcs ($name ) {

    }

    public function index()
    {


        $x = 1 ;
        $c = '1' ;

        if (Auth::user()->hasRole('admin') === 1 ) {
            // User has admin role, retrieve all clients
    $clients = Client::all();
    } else {
    // Retrieve clients that belong to the current user
    $clients = Client::where('user_id', Auth::id())->get();
    }

    return view('dashboard.clients.index', compact('clients'));
    }

    public function create() {
        return view('dashboard.clients.create');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('dashboard.clients.edit', compact('client'));
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('client_images', 'public');
        }

        $data['user_id'] = Auth::user()->id;
        $data['phone'] = $request->input('phone', ''); // Default to empty string if not provided
        $data['email'] = $request->input('email', ''); // Default to empty string if not provided
        $data['location'] = '';

        Client::create($data);

        return response()->json(['success' => 'Client created successfully.']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // Allow current email for the same client, but unique for others
            'email' => 'nullable|email|unique:clients,email,' . $request->id,
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::find($request->id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $client->update($request->all());

        return response()->json(['success' => 'Client updated successfully.']);
    }

    public function destroy(Client $client ,$id)
    {
        $client = Client::find($id);
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
        if (Auth::user()->hasRole('admin') == 1 ) {
            // User has admin role, retrieve all clients
    $clients = Client::select(['id', 'name', 'email', 'phone', 'location'])->get();
    } else {
    // Retrieve clients that belong to the current user
    $clients = Client::select(['id', 'name', 'email', 'phone', 'location'])->where('user_id', Auth::id())->get();
    }


        return datatables()->of($clients)
            ->addColumn('status', function ($client) {
                return $client->status ? 'Active' : 'Inactive'; // Display status as 'Active' or 'Inactive'
            })
            ->make(true);
    }


}
