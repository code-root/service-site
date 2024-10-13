<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{
    public function index()
    {
        $homeTranslations = [
            'en' => include resource_path('lang/en/home.php'),
            'ar' => include resource_path('lang/ar/home.php'),
        ];

        $faqTranslations = [
            'en' => include resource_path('lang/en/faqs.php'),
            'ar' => include resource_path('lang/ar/faqs.php'),
        ];

        return view('dashboard.translations.index', compact('homeTranslations', 'faqTranslations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'home_en' => 'required|array',
            'home_ar' => 'required|array',
            'faq_en' => 'required|array',
            'faq_ar' => 'required|array',
        ]);

        $this->saveTranslation('en', 'home', $request->home_en);
        $this->saveTranslation('ar', 'home', $request->home_ar);
        $this->saveTranslation('en', 'faqs', $request->faq_en);
        $this->saveTranslation('ar', 'faqs', $request->faq_ar);

        return response()->json(['success' => 'Translations updated successfully']);
    }

    private function saveTranslation($locale, $file, $content)
    {
        $filePath = resource_path("lang/{$locale}/{$file}.php");

        $contentArray = var_export($content, true);
        $contentArray = str_replace("array (", "[", $contentArray);
        $contentArray = str_replace(")", "]", $contentArray);
        $contentArray = str_replace("=> \n", "=> ", $contentArray);
        $contentArray = str_replace(",\n", ",\n    ", $contentArray);
        $contentArray = preg_replace('/\[\n\s+\]/', '[]', $contentArray);
        
        $content = "<?php\n\nreturn " . $contentArray . ";\n";

        File::put($filePath, $content);
    }
}
