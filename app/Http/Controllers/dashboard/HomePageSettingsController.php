<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;

use App\Models\HomePageSettings;
use Illuminate\Http\Request;

class HomePageSettingsController extends Controller
{
    public function edit()
    {
        $settings = HomePageSettings::where('id',1)->first(); // يمكنك تغيير هذا حسب طريقة تخزين البيانات الخاصة بك
        return view('dashboard.homepage.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = HomePageSettings::firstOrFail(); 
        $settings->update([
            'title1' => $request->input('title1'),
            'title2' => $request->input('title2'),
            'title3' => $request->input('title3'),
            'title_description' => $request->input('title_description'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $coverImageName = sha1(time()) .'.'. $image->getClientOriginalExtension();
            $filePath = $image->storeAs($coverImageName);
            $settings->update(['image_description'=>$filePath]);
    
        }
    
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
