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
        $settings = Setting::where('type', $language)->pluck('value', 'slug')->toArray();
        // إعداد المتغيرات بناءً على اللغة
        $fields = [
            'site_name' => $settings['site_name'] ?? '',
            'phone' => $settings['phone'] ?? '',
            'email' => $settings['email'] ?? '',
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
            'facebook' => $settings['facebook'] ??  '',
            'twitter' => $settings['twitter'] ??  '',
            'instagram' => $settings['instagram'] ??  '',
            'blogger' => $settings['blogger'] ??  '',
            'linkedin' => $settings['linkedin'] ??  '',
            'youtube' => $settings['youtube'] ??  '',
            'snapchat' => $settings['snapchat'] ??  '',
            'tiktok' => $settings['tiktok'] ??  '',
            'whatsapp' => $settings['whatsapp'] ??  '',
            'google_maps' => $settings['google_maps'] ??  '',
            'x' => $settings['x'] ??  '',
        ];

        return response()->json($fields);
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'slug')->toArray();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,ar', // إضافة تحقق للغة
            'site_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'footer_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'blogger' => 'nullable|string|max:255',
            'about_us' => 'nullable|string|max:255',
            'x' => 'nullable|string|max:255',
            'google_maps' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',
            'dark_mode' => 'boolean', 

        ]);

        $language = $request->input('language'); // الحصول على اللغة المختارة
        $suffix = $language === 'ar' ? '_ar' : '_en'; // تحديد اللاحقة

        // الحقول الأساسية التي لا تحتاج إلى اللاحقة
        $basicFields = [
            'phone',
            'email',
            'facebook',
            'twitter',
            'instagram',
            'linkedin',
            'youtube',
            'snapchat',
            'tiktok',
            'blogger' ,
            'x',
            'dark_mode',
            'google_maps',
            'whatsapp',
            'site_name',
        ];

        // إعداد البيانات
        $settingsData = $request->only(array_merge($basicFields, [
            'about_intro',
            'about_mission',
            'about_vision',
            'faq_pre_title',
            'faq_title',
            'faq_description',
            'contact_title',
            'about_us',
            'contact_title_2',
            'footer_description',
        ]));

        // تحديث القيم الأساسية
        foreach ($basicFields as $field) {
            if (isset($settingsData[$field])) {
                Setting::updateOrCreate(
                    ['slug' => $field], // استخدام اسم الحقل كـ slug
                    ['value' => $settingsData[$field]]
                );
            }
        }

        // إضافة اللاحقة إلى الحقول غير الأساسية
        foreach ($settingsData as $key => $value) {
            if (!in_array($key, $basicFields)) {
                Setting::updateOrCreate(
                    ['slug' => $key, 'type' => $language],
                    ['value' => $value]
                );
            }
        }

        // تحديث الشعار إذا تم رفع ملف جديد
        if ($request->hasFile('logo')) {
            $logoPath =   $request->file('logo')->store('logos');
            Setting::updateOrCreate(
                ['slug' => 'logo'],
                ['value' => $logoPath]
            );
        }

        if ($request->hasFile('about_image_2')) {
            $logoPath =   $request->file('about_image_2')->store('aboutImage');

            Setting::updateOrCreate(
                ['slug' => 'about_image_2'],
                ['value' => $logoPath]
            );
        }

        if ($request->hasFile('about_image_1')) {
            $logoPath =   $request->file('about_image_1')->store('aboutImage');
            Setting::updateOrCreate(
                ['slug' => 'about_image_1'],
                ['value' => $logoPath]
            );
        }


        return response()->json(['success' => 'Settings updated successfully.']);
    }
}
