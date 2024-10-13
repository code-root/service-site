<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'slug')->toArray();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'footer_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_intro' => 'nullable|string',
            'about_mission' => 'nullable|string',
            'about_vision' => 'nullable|string',
            'faq_pre_title' => 'nullable|string|max:255',
            'faq_title' => 'nullable|string|max:255',
            'faq_description' => 'nullable|string',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'snapchat' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'x' => 'nullable|string|max:255',

        ]);
        
        $settingsData = $request->only([
            'site_name', 'phone', 'email', 'footer_description', 
            'about_intro', 'about_mission', 'about_vision',
            'faq_pre_title', 'faq_title', 'faq_description',
            'facebook', 'twitter', 'instagram', 'linkedin',
            'youtube', 'snapchat', 'tiktok',
             'x' ,
             'contact_title' ,
             'contact_title_2' ,
             'whatsapp' ,
             
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $settingsData['logo'] = '/app/public/'.$logoPath;
        }

        foreach ($settingsData as $slug => $value) {
            Setting::updateOrCreate(
                ['slug' => $slug],
                ['value' => $value]
            );
        }

        return response()->json(['success' => 'Settings updated successfully.']);
    }
}
