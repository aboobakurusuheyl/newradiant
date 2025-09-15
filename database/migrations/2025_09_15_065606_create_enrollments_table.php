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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            
            // Student Information
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['M', 'F']);
            $table->string('id_number')->nullable();
            $table->text('home_address');
            $table->string('telephone_no');
            $table->string('nationality');
            $table->string('school_attended');
            
            // Parent/Guardian Information
            $table->string('parent_name');
            $table->string('parent_telephone');
            
            // Photograph
            $table->string('photograph_path')->nullable();
            
            // How they heard about us
            $table->enum('heard_about', ['newspaper', 'family_friends', 'social_media', 'other']);
            $table->string('heard_about_other')->nullable();
            
            // Office Use (Admin fields)
            $table->string('application_received_by')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('squad')->nullable();
            $table->string('centre')->nullable();
            $table->text('remarks')->nullable();
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
