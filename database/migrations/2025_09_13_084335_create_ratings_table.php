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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->integer('skill_rating')->unsigned(); // 1-10
            $table->integer('discipline_rating')->unsigned(); // 1-10
            $table->integer('fitness_rating')->unsigned(); // 1-10
            $table->integer('overall_rating')->unsigned(); // 1-10
            $table->text('notes')->nullable();
            $table->string('period'); // monthly, weekly, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
