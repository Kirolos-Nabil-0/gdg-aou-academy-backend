<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Adds GDG-specific fields to the users table
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename 'name' to 'full_name' for clarity
            $table->renameColumn('name', 'full_name');

            // College relationship
            $table->foreignId('college_id')->nullable()->constrained('colleges')->onDelete('set null');

            // CS/non-CS flag
            $table->boolean('is_cs')->default(false);

            // Encrypted sensitive fields (will be encrypted at application level)
            $table->text('national_id_encrypted')->nullable();
            $table->text('phone_encrypted')->nullable();

            // Locale preference for multilanguage support
            $table->string('locale', 2)->default('en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('full_name', 'name');
            $table->dropForeign(['college_id']);
            $table->dropColumn(['college_id', 'is_cs', 'national_id_encrypted', 'phone_encrypted', 'locale']);
        });
    }
};
