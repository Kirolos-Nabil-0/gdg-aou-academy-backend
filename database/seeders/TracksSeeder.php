<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds course tracks for GDG technical programs
     */
    public function run(): void
    {
        $tracks = [
            [
                'name' => 'Web Development',
                'name_ar' => 'تطوير الويب',
                'description' => 'Full-stack web development with modern frameworks and technologies',
            ],
            [
                'name' => 'Mobile Development',
                'name_ar' => 'تطوير تطبيقات الموبايل',
                'description' => 'Native and cross-platform mobile app development',
            ],
            [
                'name' => 'Machine Learning',
                'name_ar' => 'تعلم الآلة',
                'description' => 'Machine learning, deep learning, and AI fundamentals',
            ],
            [
                'name' => 'Cloud Computing',
                'name_ar' => 'الحوسبة السحابية',
                'description' => 'Cloud platforms, DevOps, and infrastructure',
            ],
            [
                'name' => 'Data Science',
                'name_ar' => 'علم البيانات',
                'description' => 'Data analysis, visualization, and statistical modeling',
            ],
            [
                'name' => 'Cybersecurity',
                'name_ar' => 'الأمن السيبراني',
                'description' => 'Security fundamentals, ethical hacking, and secure coding',
            ],
            [
                'name' => 'UI/UX Design',
                'name_ar' => 'تصميم واجهات المستخدم',
                'description' => 'User interface and user experience design principles',
            ],
            [
                'name' => 'Game Development',
                'name_ar' => 'تطوير الألعاب',
                'description' => 'Game design and development with modern engines',
            ],
        ];

        DB::table('tracks')->insert($tracks);
    }
}
