<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getFields(Request $request)
    {
        $language = $request->input('language');
        $settings = $this->getFieldsByLanguage($language);

        return response()->json([
            'footer_description' => $settings['footer_description'] ?? '',
            'about_intro' => $settings['about_intro'] ?? '',
            'about_mission' => $settings['about_mission'] ?? '',
            'about_us' => $settings['about_us'] ?? '',
            'about_vision' => $settings['about_vision'] ?? '',
            'faq_pre_title' => $settings['faq_pre_title'] ?? '',
            'faq_title' => $settings['faq_title'] ?? '',
            'faq_description' => $settings['faq_description'] ?? '',
            'contact_title' => $settings['contact_title'] ?? '',
            'contact_title_2' => $settings['contact_title_2'] ?? '',
            'categories_services' => $settings['categories_services'] ?? '',
            'categories_creativity_and_passion' => $settings['categories_creativity_and_passion'] ?? '',
            'categories_description' => $settings['categories_description'] ?? '',
            'categories_start_today' => $settings['categories_start_today'] ?? '',
            'services_popular_services' => $settings['services_popular_services'] ?? '',
            'services_choose_service' => $settings['services_choose_service'] ?? '',
            'services_subscribers' => $settings['services_subscribers'] ?? '',
            'services_views' => $settings['services_views'] ?? '',
            'banner_title' => $settings['banner_title'] ?? '',
            'banner_description' => $settings['banner_description'] ?? '',
            'banner_button_text' => $settings['banner_button_text'] ?? '',
        ]);
    }

    public function index()
    {
        $settings = Setting::where('type', '!=', 'basic')->pluck('value', 'slug')->toArray();
        $basic = Setting::where('type', 'basic')->pluck('value', 'slug')->toArray();
        return view('dashboard.settings.index', compact('settings', 'basic'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,ar',
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'footer_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'google_maps' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',
            'dark_mode' => 'boolean',
            'slider' => 'boolean',
            'contact_title_2' => 'nullable|string|max:255',
            'categories_services' => 'nullable|string|max:255',
            'categories_creativity_and_passion' => 'nullable|string|max:255',
            'categories_description' => 'nullable|string',
            'categories_start_today' => 'nullable|string|max:255',
            'services_popular_services' => 'nullable|string|max:255',
            'services_choose_service' => 'nullable|string|max:255',
            'services_subscribers' => 'nullable|string|max:255',
            'services_views' => 'nullable|string|max:255',
            'banner_title' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:255',
        ]);

        $language = $request->input('language');
        $settingsData = $request->except(['_token', 'logo', 'about_image_1', 'about_image_2']);

        // تحديث الحقول النصية
        foreach ($settingsData as $key => $value) {
            $this->updateField($key, in_array($key, $this->basicFields()) ? 'basic' : $language, $value);
        }

        // رفع الملفات
        $this->updateFile($request, 'logo', 'logos');
        $this->updateFile($request, 'about_image_1', 'aboutImage');
        $this->updateFile($request, 'about_image_2', 'aboutImage');

        return response()->json(['success' => 'Settings updated successfully.']);
    }

    protected function updateField($slug, $type, $value)
    {
        Setting::updateOrCreate(
            ['slug' => $slug, 'type' => $type],
            ['value' => $value]
        );
    }

    protected function updateFile(Request $request, $field, $path)
    {
        if ($request->hasFile($field)) {
            $filePath = $request->file($field)->store($path);
            $this->updateField($field, 'basic', $filePath);
        }
    }

    protected function getFieldsByLanguage($language)
    {
        return Setting::where('type', $language)->pluck('value', 'slug')->toArray();
    }

    protected function basicFields()
    {
        return [
            'phone',
            'email',
            'site_name',
            'facebook',
            'slider' ,
            'twitter',
            'instagram',
            'linkedin',
            'youtube',
            'snapchat',
            'tiktok',
            'google_maps',
            'whatsapp',
            'dark_mode',
        ];
    }
}
