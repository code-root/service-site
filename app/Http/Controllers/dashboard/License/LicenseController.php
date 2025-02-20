<?php

namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;

use App\Models\License;
use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LicenseController extends Controller
{
    /*** Display all licenses page.*/

    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            // If the user has the admin role, retrieve all licenses
            $licenses = License::with('client', 'program')->get();

            } else {
            // If not, retrieve only the licenses for the current user
            $licenses = License::where('user_id', Auth::id())
            ->with('client', 'program')
            ->get();
            }

        return view('dashboard.licenses.index', compact('licenses'));
    }

    /*** Display the new license addition form. */
    public function create()
    {
        $clients = Client::all();
        $programs = Program::all();
        return view('dashboard.licenses.create', compact('clients', 'programs'));
    }

    /*** Store new license. */

    public function store(Request $request)
        {
            $request->validate([
                'activation_code' => 'required|unique:licenses',
                'client_id' => 'required|exists:clients,id',
                'program_id' => 'required|exists:programs,id',
                'purchase_date' => 'required|date',
                'expiry_date' => 'required|date',
            ]);

            // Ensure the key is correctly handled before saving
            $activationCode = $request->input('activation_code');
            $encryptedCode = $this->generateKey($activationCode);

            // Add the encrypted code to the request data before saving
            $licenseData = $request->all();
            $licenseData['user_id'] = Auth::user()->id;
            $licenseData['activation_code'] = $encryptedCode;
            $licenseData['serial_number'] = $activationCode;

            License::create($licenseData);

            return response()->json(['success' => 'License updated successfully']);
        }

    public function generateKey($activationCode)
        {
            $h = $activationCode;
            $h = str_replace(
                ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
                ['D', 'M', 'N', 'C', 'K', 'K', 'Y', 'Q', 'X', 'Z', 'Z', 'Y', 'F', 'Z', 'M', 'T', 'O', 'S', 'K', 'Z', 'O', 'Z', 'T', 'P', 'Q', 'N'],
                $h
            );
            $n = '';
            for ($i = 0; $i < strlen($h) - 7; $i++) {
                $n .= $h[$i];
            }
            return $n;
        }

    /**
    * View license modification form.
     */
    public function edit($id)
    {
        $license = License::findOrFail($id);
        $clients = Client::all();
        $programs = Program::all();
        return view('dashboard.licenses.edit', compact('license', 'clients', 'programs'));
    }

    /*** Update license data. */
    public function update(Request $request, $id)
    {
        $request->validate([
            'activation_code' => 'required|unique:licenses,activation_code,' . $id,
            'client_id'       => 'required|exists:clients,id',
            'program_id'      => 'required|exists:programs,id',
            'is_active'       => 'nullable|boolean',
            'purchase_date'   => 'required|date',
            'expiry_date'     => 'required|date',
        ]);

      // If is_active is not sent, set it to 0
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $license = License::findOrFail($id);
        $license->update($data);

        return redirect()->route('license.index')->with('success', 'License updated successfully');
    }

    /**
    * Delete license.
    */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();
        return redirect()->route('license.index')->with('success', 'License deleted successfully');
    }
}
