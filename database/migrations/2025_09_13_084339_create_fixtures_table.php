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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('opponent');
            $table->date('match_date');
            $table->time('match_time');
            $table->string('venue');
            $table->enum('type', ['home', 'away', 'neutral']);
            $table->string('competition')->nullable(); // league, cup, friendly
            $table->string('age_group')->nullable(); // U8, U10, U12, U14, U16, U18, Senior
            $table->integer('our_score')->nullable();
            $table->integer('opponent_score')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'postponed'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
