<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the courses table with all fields from PRD
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Track relationship
            $table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');

            // Schedule
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Capacity (informational only, not enforced)
            $table->integer('capacity')->nullable();

            // Status: draft, published, archived
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // Visibility: public, hidden
            $table->enum('visibility', ['public', 'hidden'])->default('public');

            // Enrollability flag - controls if learners can currently enroll
            $table->boolean('is_enrollable')->default(true);

            // Waitlist feature (optional)
            $table->boolean('waitlist_enabled')->default(false);

            // Instructor assignment
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');

            // Audit fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Indexes for common queries
            $table->index(['track_id', 'status', 'is_enrollable']);
            $table->index('visibility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
