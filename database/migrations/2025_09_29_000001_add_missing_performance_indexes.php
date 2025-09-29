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
        // Add missing performance indexes
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at']);
            $table->index(['is_featured', 'created_at']);
            $table->index(['category_id', 'is_published']);
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['is_published', 'created_at']);
            $table->index(['is_featured', 'sort_order']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->index(['is_published', 'created_at']);
            $table->index(['is_home']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'published_at']);
            $table->dropIndex(['is_featured', 'created_at']);
            // Skip dropping category_id index as it might be used by foreign key
            // $table->dropIndex(['category_id', 'is_published']);
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'created_at']);
            $table->dropIndex(['is_featured', 'sort_order']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'created_at']);
            $table->dropIndex(['is_home']);
        });
    }
};
