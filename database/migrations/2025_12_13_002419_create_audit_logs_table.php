<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the audit_logs table for tracking important system actions
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action_type'); // e.g., 'login', 'enrollment_created', 'grade_updated'
            $table->string('entity_type')->nullable(); // e.g., 'Course', 'Enrollment', 'Grade'
            $table->unsignedBigInteger('entity_id')->nullable(); // ID of the affected entity
            $table->json('metadata')->nullable(); // Additional context (old/new values, IP, etc.)
            $table->timestamp('created_at')->useCurrent();

            // Indexes for audit queries
            $table->index(['entity_type', 'entity_id']);
            $table->index('user_id');
            $table->index('action_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
