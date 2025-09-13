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
        Schema::table('students', function (Blueprint $table) {
            $table->string('experience')->nullable()->after('medical_notes');
            $table->string('emergency_contact_name')->nullable()->after('experience');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_relation')->nullable()->after('emergency_contact_phone');
            $table->enum('enrollment_status', ['pending', 'approved', 'rejected'])->default('pending')->after('emergency_contact_relation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'experience',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relation',
                'enrollment_status'
            ]);
        });
    }
};