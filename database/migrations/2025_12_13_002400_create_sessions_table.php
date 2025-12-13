<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Creates the course_sessions table for course sessions/classes
     * (renamed from 'sessions' to avoid conflict with Laravel's session table)
     */
    public function up(): void
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->enum('modality', ['online', 'offline'])->default('online'); // MVP is online-only
            $table->string('location')->nullable(); // Meeting link or physical location
            $table->timestamps();

            $table->index(['course_id', 'start_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sessions');
    }
};
