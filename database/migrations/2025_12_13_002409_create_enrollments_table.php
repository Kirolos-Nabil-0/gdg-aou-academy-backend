<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the enrollments table for learner course enrollments
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Status: enrolled, waitlisted, dropped, completed
            $table->enum('status', ['enrolled', 'waitlisted', 'dropped', 'completed'])->default('enrolled');

            // Waitlist position (null if not waitlisted)
            $table->integer('waitlist_position')->nullable();

            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();

            // Unique constraint: one enrollment per user per course
            $table->unique(['course_id', 'user_id']);

            // Indexes for common queries
            $table->index(['course_id', 'status']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
