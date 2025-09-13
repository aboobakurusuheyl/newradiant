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
        Schema::table('news', function (Blueprint $table) {
            $table->text('excerpt')->nullable();
            $table->string('category')->default('general');
            $table->json('tags')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn([
                'excerpt',
                'category',
                'tags',
                'is_featured',
                'sort_order',
                'expires_at',
                'meta_title',
                'meta_description'
            ]);
        });
    }
};
