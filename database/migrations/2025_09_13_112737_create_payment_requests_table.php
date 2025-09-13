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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade'); // Admin who requested
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('MVR');
            $table->text('description');
            $table->string('account_number');
            $table->string('bank_name');
            $table->enum('status', ['pending', 'paid', 'verified', 'rejected'])->default('pending');
            $table->string('receipt_path')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('parent_notes')->nullable();
            $table->timestamp('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};