<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the course_final_grades table for calculated final grades
     */
    public function up(): void
    {
        Schema::create('course_final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('final_grade', 5, 2); // Weighted average of all assignments
            $table->enum('status', ['passed', 'failed'])->nullable();
            $table->timestamp('calculated_at')->useCurrent();
            $table->timestamps();

            // Unique constraint: one final grade per user per course
            $table->unique(['course_id', 'user_id']);

            // Indexes
            $table->index('course_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_final_grades');
    }
};
