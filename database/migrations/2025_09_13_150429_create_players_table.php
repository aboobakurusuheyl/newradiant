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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')->nullable(); // e.g., "Vini Jr."
            $table->integer('jersey_number')->unique();
            $table->string('position'); // Goalkeeper, Defender, Midfielder, Forward
            $table->string('position_detail')->nullable(); // e.g., "Left Back", "Center Forward"
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->integer('height')->nullable(); // in cm
            $table->integer('weight')->nullable(); // in kg
            $table->string('preferred_foot')->nullable(); // Left, Right, Both
            $table->string('photo')->nullable();
            $table->text('biography')->nullable();
            $table->json('career_stats')->nullable(); // Goals, Assists, Appearances, etc.
            $table->json('achievements')->nullable(); // Trophies, Awards, etc.
            $table->string('contract_start')->nullable();
            $table->string('contract_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_captain')->default(false);
            $table->boolean('is_vice_captain')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
