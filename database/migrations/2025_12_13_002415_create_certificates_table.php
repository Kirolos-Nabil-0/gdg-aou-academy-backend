<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the certificates table for generated certificates
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('certificate_number')->unique(); // Unique certificate ID
            $table->string('file_url'); // Path or URL to PDF certificate
            $table->enum('status', ['pending', 'issued', 'revoked'])->default('issued');

            // Snapshot of criteria at time of issuance (for audit)
            $table->json('criteria_snapshot')->nullable();

            // Audit fields
            $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('issued_at')->useCurrent();

            $table->timestamps();

            // Unique constraint: one certificate per user per course
            $table->unique(['course_id', 'user_id']);

            // Indexes
            $table->index('course_id');
            $table->index('user_id');
            $table->index('certificate_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
