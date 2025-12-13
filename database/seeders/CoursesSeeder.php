<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates sample courses
     */
    public function run(): void
    {
        // Get users by role
        $instructor = User::role('Instructor')->first();
        $admin = User::role('Admin')->first();

        // Fallback to first user if roles not found
        if (!$instructor)
            $instructor = User::first();
        if (!$admin)
            $admin = User::first();

        // Course 1: Web Development Bootcamp (Published, Enrollable)
        $webCourse = DB::table('courses')->insertGetId([
            'title' => 'Full-Stack Web Development Bootcamp',
            'description' => 'Comprehensive web development course covering HTML, CSS, JavaScript, React, Node.js, and databases.',
            'track_id' => 1, // Web Development
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addDays(67),
            'capacity' => 50,
            'status' => 'published',
            'visibility' => 'public',
            'is_enrollable' => true,
            'waitlist_enabled' => false,
            'instructor_id' => $instructor->id,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add sessions for Web Course
        DB::table('course_sessions')->insert([
            [
                'course_id' => $webCourse,
                'title' => 'Kickoff Session',
                'start_at' => Carbon::now()->addDays(7)->setTime(18, 0),
                'end_at' => Carbon::now()->addDays(7)->setTime(20, 0),
                'modality' => 'online',
                'location' => 'https://meet.google.com/abc-defg-hij',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => $webCourse,
                'title' => 'HTML & CSS Workshop',
                'start_at' => Carbon::now()->addDays(14)->setTime(18, 0),
                'end_at' => Carbon::now()->addDays(14)->setTime(20, 0),
                'modality' => 'online',
                'location' => 'https://meet.google.com/abc-defg-hij',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Course 2: Machine Learning Fundamentals (Published, Enrollable)
        DB::table('courses')->insert([
            'title' => 'Machine Learning Fundamentals',
            'description' => 'Introduction to machine learning concepts, algorithms, and practical applications using Python.',
            'track_id' => 3, // Machine Learning
            'start_date' => Carbon::now()->addDays(14),
            'end_date' => Carbon::now()->addDays(74),
            'capacity' => 30,
            'status' => 'published',
            'visibility' => 'public',
            'is_enrollable' => true,
            'waitlist_enabled' => true,
            'instructor_id' => $instructor->id,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Course 3: Mobile App Development (Draft)
        DB::table('courses')->insert([
            'title' => 'Flutter Mobile Development',
            'description' => 'Build cross-platform mobile apps with Flutter and Dart.',
            'track_id' => 2, // Mobile Development
            'start_date' => Carbon::now()->addDays(30),
            'end_date' => Carbon::now()->addDays(90),
            'capacity' => 40,
            'status' => 'draft',
            'visibility' => 'hidden',
            'is_enrollable' => false,
            'waitlist_enabled' => false,
            'instructor_id' => $instructor->id,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Course 4: Cloud Computing (Archived)
        DB::table('courses')->insert([
            'title' => 'AWS Cloud Practitioner',
            'description' => 'AWS fundamentals and cloud computing basics.',
            'track_id' => 4, // Cloud Computing
            'start_date' => Carbon::now()->subDays(90),
            'end_date' => Carbon::now()->subDays(30),
            'capacity' => 25,
            'status' => 'archived',
            'visibility' => 'public',
            'is_enrollable' => false,
            'waitlist_enabled' => false,
            'instructor_id' => $instructor->id,
            'created_by' => $admin->id,
            'created_at' => now()->subDays(100),
            'updated_at' => now(),
        ]);
    }
}
