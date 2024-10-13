<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            [
                'meta_ar' => 'سياسة الخصوصية',
                'meta_en' => 'Privacy Policy',
                'name_ar' => 'سياسة الخصوصية',
                'name_en' => 'Privacy Policy',
                'description_ar' => 'محتوى سياسة الخصوصية هنا',
                'description_en' => 'Privacy policy content here',
            ],
            [
                'meta_ar' => 'سياسة الاستخدام',
                'meta_en' => 'Terms of Use',
                'name_ar' => 'سياسة الاستخدام',
                'name_en' => 'Terms of Use',
                'description_ar' => 'محتوى سياسة الاستخدام هنا',
                'description_en' => 'Terms of use content here',
            ],
            [
                'meta_ar' => 'من نحن',
                'meta_en' => 'About Us',
                'name_ar' => 'من نحن',
                'name_en' => 'About Us',
                'description_ar' => 'محتوى من نحن هنا',
                'description_en' => 'About us content here',
            ],
            [
                'meta_ar' => 'اتصل بنا',
                'meta_en' => 'Contact Us',
                'name_ar' => 'اتصل بنا',
                'name_en' => 'Contact Us',
                'description_ar' => 'محتوى اتصل بنا هنا',
                'description_en' => 'Contact us content here',
            ],
        ]);
    }
}
