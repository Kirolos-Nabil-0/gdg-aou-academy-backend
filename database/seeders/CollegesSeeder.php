<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds Egyptian universities/colleges for AOU region
     */
    public function run(): void
    {
        $colleges = [
            ['name' => 'Arab Open University', 'name_ar' => 'الجامعة العربية المفتوحة'],
            ['name' => 'Cairo University', 'name_ar' => 'جامعة القاهرة'],
            ['name' => 'Ain Shams University', 'name_ar' => 'جامعة عين شمس'],
            ['name' => 'Alexandria University', 'name_ar' => 'جامعة الإسكندرية'],
            ['name' => 'Helwan University', 'name_ar' => 'جامعة حلوان'],
            ['name' => 'Mansoura University', 'name_ar' => 'جامعة المنصورة'],
            ['name' => 'Zagazig University', 'name_ar' => 'جامعة الزقازيق'],
            ['name' => 'Assiut University', 'name_ar' => 'جامعة أسيوط'],
            ['name' => 'Tanta University', 'name_ar' => 'جامعة طنطا'],
            ['name' => 'Benha University', 'name_ar' => 'جامعة بنها'],
            ['name' => 'Fayoum University', 'name_ar' => 'جامعة الفيوم'],
            ['name' => 'Beni-Suef University', 'name_ar' => 'جامعة بني سويف'],
            ['name' => 'Suez Canal University', 'name_ar' => 'جامعة قناة السويس'],
            ['name' => 'South Valley University', 'name_ar' => 'جامعة جنوب الوادي'],
            ['name' => 'Minia University', 'name_ar' => 'جامعة المنيا'],
            ['name' => 'German University in Cairo', 'name_ar' => 'الجامعة الألمانية بالقاهرة'],
            ['name' => 'American University in Cairo', 'name_ar' => 'الجامعة الأمريكية بالقاهرة'],
            ['name' => 'Nile University', 'name_ar' => 'جامعة النيل'],
            ['name' => 'October 6 University', 'name_ar' => 'جامعة 6 أكتوبر'],
            ['name' => 'Other', 'name_ar' => 'أخرى'],
        ];

        DB::table('colleges')->insert($colleges);
    }
}
