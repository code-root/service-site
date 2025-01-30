<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function activate(Request $request)
    {
        $request->validate([
            'activation_code' => 'required|exists:licenses,activation_code',
        ]);

        $license = License::where('activation_code', $request->activation_code)->first();
        $license->update(['is_active' => true]);

        return redirect()->back()->with('success', 'License activated successfully.');
    }
}
