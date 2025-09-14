<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        
        // Add the new role column with only admin and member
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'member'])->default('member');
        });
        
        // Update existing users - set first user as admin, rest as members
        $users = DB::table('users')->get();
        foreach ($users as $index => $user) {
            $role = $index === 0 ? 'admin' : 'member';
            DB::table('users')->where('id', $user->id)->update(['role' => $role]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original role enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'coach', 'student', 'parent'])->default('student')->change();
        });
    }
};