<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates test users for each role with realistic data
     */
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'full_name' => 'admin',
            'email' => 'admin@gdg.com',
            'password' => Hash::make('password'),
            'college_id' => 1, // Arab Open University
            'is_cs' => true,
            'national_id_encrypted' => Crypt::encryptString('29012345678901'),
            'phone_encrypted' => Crypt::encryptString('+201234567890'),
            'locale' => 'en',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // HR users
        $hr1 = User::create([
            'full_name' => 'hr',
            'email' => 'hr@gdg.com',
            'password' => Hash::make('password'),
            'college_id' => 1,
            'is_cs' => false,
            'national_id_encrypted' => Crypt::encryptString('29112345678902'),
            'phone_encrypted' => Crypt::encryptString('+201234567891'),
            'locale' => 'ar',
            'email_verified_at' => now(),
        ]);
        $hr1->assignRole('HR');

        // Instructor users
        $instructor1 = User::create([
            'full_name' => 'instructor.web',
            'email' => 'instructor.web@gdg.com',
            'password' => Hash::make('password'),
            'college_id' => 1,
            'is_cs' => true,
            'national_id_encrypted' => Crypt::encryptString('28512345678903'),
            'phone_encrypted' => Crypt::encryptString('+201234567892'),
            'locale' => 'en',
            'email_verified_at' => now(),
        ]);
        $instructor1->assignRole('Instructor');

        $instructor2 = User::create([
            'full_name' => 'instructor.ml',
            'email' => 'instructor.ml@gdg.com',
            'password' => Hash::make('password'),
            'college_id' => 2, // Cairo University
            'is_cs' => true,
            'national_id_encrypted' => Crypt::encryptString('29312345678904'),
            'phone_encrypted' => Crypt::encryptString('+201234567893'),
            'locale' => 'en',
            'email_verified_at' => now(),
        ]);
        $instructor2->assignRole('Instructor');

        // Learner users (10 students with varied backgrounds)
        $learners = [
            ['full_name' => 'learner.web', 'email' => 'learner1@example.com', 'college_id' => 1, 'is_cs' => true],
            ['full_name' => 'learner.ml', 'email' => 'learner2@example.com', 'college_id' => 2, 'is_cs' => true],
            ['full_name' => 'learner.cs', 'email' => 'learner3@example.com', 'college_id' => 3, 'is_cs' => false],
            ['full_name' => 'learner.ai', 'email' => 'learner4@example.com', 'college_id' => 1, 'is_cs' => true],
            ['full_name' => 'learner.data', 'email' => 'learner5@example.com', 'college_id' => 4, 'is_cs' => false],
            ['full_name' => 'learner.security', 'email' => 'learner6@example.com', 'college_id' => 2, 'is_cs' => true],
            ['full_name' => 'learner.game', 'email' => 'learner7@example.com', 'college_id' => 1, 'is_cs' => true],
            ['full_name' => 'learner.app', 'email' => 'learner8@example.com', 'college_id' => 5, 'is_cs' => false],
            ['full_name' => 'learner.business', 'email' => 'learner9@example.com', 'college_id' => 3, 'is_cs' => true],
            ['full_name' => 'learner.business', 'email' => 'learner10@example.com', 'college_id' => 2, 'is_cs' => false],
        ];

        foreach ($learners as $index => $learnerData) {
            $learner = User::create([
                'full_name' => $learnerData['full_name'],
                'email' => $learnerData['email'],
                'password' => Hash::make('password'),
                'college_id' => $learnerData['college_id'],
                'is_cs' => $learnerData['is_cs'],
                'national_id_encrypted' => Crypt::encryptString('2951234567890' . ($index + 5)),
                'phone_encrypted' => Crypt::encryptString('+20123456789' . ($index + 4)),
                'locale' => $index % 2 == 0 ? 'en' : 'ar',
                'email_verified_at' => now(),
            ]);
            $learner->assignRole('Learner');
        }
    }
}
