<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('company_name');
            $table->string('location');
            $table->decimal('salary', 10, 2);
            $table->string('experience_level')->nullable(); // New field for experience level
            $table->enum('job_type', ['full-time', 'part-time', 'remote'])->nullable(); // New field for job type
            $table->string('industry')->nullable(); // New field for industry
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn(['experience_level', 'job_type', 'industry']); // Drop the new columns
        });
    }
};
