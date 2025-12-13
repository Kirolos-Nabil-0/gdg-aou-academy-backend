<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Seeds all tables with test data for GDG Learning Platform
     */
    public function run(): void
    {
        // Seed in correct order due to foreign key constraints
        $this->call([
            CollegesSeeder::class,
            TracksSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            CoursesSeeder::class,
        ]);
    }
}
