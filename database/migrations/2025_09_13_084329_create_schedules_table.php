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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location');
            $table->string('age_group')->nullable(); // U8, U10, U12, U14, U16, U18, Senior, All
            $table->enum('type', ['training', 'match', 'tournament', 'meeting', 'other']);
            $table->foreignId('coach_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_pattern')->nullable(); // weekly, monthly, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
