<?php

namespace App\Http\Controllers\dashboard\License;
use App\Http\Controllers\Controller;

use App\Models\License;
use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * عرض صفحة كل التراخيص.
     */
    public function index()
    {
        $licenses = License::with('client', 'program')->get();
        return view('dashboard.licenses.index', compact('licenses'));
    }

    /**
     * عرض نموذج إضافة ترخيص جديد.
     */
    public function create()
    {
        $clients = Client::all();
        $programs = Program::all();
        return view('dashboard.licenses.create', compact('clients', 'programs'));
    }

    /**
     * تخزين ترخيص جديد.
     */
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
        $licenseData['activation_code'] = $encryptedCode;

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
     * عرض نموذج تعديل الترخيص.
     */
    public function edit($id)
    {
        $license = License::findOrFail($id);
        $clients = Client::all();
        $programs = Program::all();
        return view('dashboard.licenses.edit', compact('license', 'clients', 'programs'));
    }

    /**
     * تحديث بيانات الترخيص.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'activation_code' => 'required|unique:licenses,activation_code,' . $id,
            'client_id' => 'required|exists:clients,id',
            'program_id' => 'required|exists:programs,id',
            'is_active' => 'required|boolean',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date',
        ]);

        $license = License::findOrFail($id);
        $license->update($request->all());

        return redirect()->route('dashboard.licenses.index')->with('success', 'تم تحديث الترخيص بنجاح');
    }

    /**
     * حذف ترخيص.
     */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();

        return redirect()->route('dashboard.licenses.index')->with('success', 'تم حذف الترخيص بنجاح');
    }
}
