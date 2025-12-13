<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates roles and permissions for the GDG Learning Platform
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'assign-roles',

            // Course management
            'view-courses',
            'create-courses',
            'edit-courses',
            'delete-courses',
            'publish-courses',

            // Enrollment management
            'view-enrollments',
            'create-enrollments',
            'edit-enrollments',
            'delete-enrollments',

            // Attendance management
            'view-attendance',
            'mark-attendance',
            'edit-attendance',

            // Grade management
            'view-grades',
            'enter-grades',
            'edit-grades',
            'finalize-grades',

            // Certificate management
            'view-certificates',
            'generate-certificates',
            'revoke-certificates',

            // Content management
            'manage-modules',
            'manage-lessons',
            'manage-resources',

            // Session management
            'manage-sessions',

            // Warning management
            'issue-warnings',
            'view-warnings',

            // Announcement management
            'create-announcements',
            'edit-announcements',
            'delete-announcements',

            // Dashboard access
            'view-admin-dashboard',
            'view-instructor-dashboard',
            'view-hr-dashboard',

            // Reports
            'export-data',
            'view-audit-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin role - full access
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // HR role - enrollment, attendance, certificates, warnings
        $hrRole = Role::create(['name' => 'HR']);
        $hrRole->givePermissionTo([
            'view-users',
            'view-courses',
            'view-enrollments',
            'create-enrollments',
            'edit-enrollments',
            'delete-enrollments',
            'view-attendance',
            'mark-attendance',
            'edit-attendance',
            'view-grades',
            'view-certificates',
            'generate-certificates',
            'issue-warnings',
            'view-warnings',
            'view-hr-dashboard',
            'export-data',
        ]);

        // Instructor role - course content, grading, attendance
        $instructorRole = Role::create(['name' => 'Instructor']);
        $instructorRole->givePermissionTo([
            'view-courses',
            'create-courses',
            'edit-courses',
            'view-enrollments',
            'view-attendance',
            'mark-attendance',
            'view-grades',
            'enter-grades',
            'edit-grades',
            'finalize-grades',
            'manage-modules',
            'manage-lessons',
            'manage-resources',
            'manage-sessions',
            'create-announcements',
            'edit-announcements',
            'delete-announcements',
            'view-instructor-dashboard',
        ]);

        // Learner role - view own data
        $learnerRole = Role::create(['name' => 'Learner']);
        $learnerRole->givePermissionTo([
            'view-courses',
            'view-enrollments',
            'view-attendance',
            'view-grades',
            'view-certificates',
        ]);
    }
}
