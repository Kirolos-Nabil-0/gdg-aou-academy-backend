<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the certificate_rules table for defining certificate criteria per course
     */
    public function up(): void
    {
        Schema::create('certificate_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('min_attendance', 5, 2)->default(80.00); // Minimum attendance percentage
            $table->decimal('min_final_grade', 5, 2)->default(60.00); // Minimum final grade
            $table->boolean('override_allowed')->default(true); // Allow HR to override for specific learners
            $table->timestamps();

            $table->index('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_rules');
    }
};
