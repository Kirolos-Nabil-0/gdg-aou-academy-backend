<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the attendance_records table for tracking session attendance
     */
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('course_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Status: present, absent
            $table->enum('status', ['present', 'absent'])->default('absent');

            $table->text('comment')->nullable(); // Optional note from HR/Instructor

            // Audit fields
            $table->foreignId('marked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('marked_at')->useCurrent();

            $table->timestamps();

            // Unique constraint: one attendance record per user per session
            $table->unique(['session_id', 'user_id']);

            // Indexes
            $table->index('session_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
