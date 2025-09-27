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
        // Add indexes for posts table - most critical for performance
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'posts_published_date_idx');
            $table->index(['is_featured', 'is_published'], 'posts_featured_published_idx');
            $table->index(['category_id', 'is_published'], 'posts_category_published_idx');
            $table->index(['user_id', 'is_published'], 'posts_user_published_idx');
            $table->index('views_count', 'posts_views_idx');
            $table->index('slug', 'posts_slug_idx');

            // Full-text search index for better search performance
            $table->fullText(['title', 'excerpt', 'content'], 'posts_search_idx');
        });

        // Add indexes for comments table
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['post_id', 'is_approved'], 'comments_post_approved_idx');
            $table->index(['parent_id', 'is_approved'], 'comments_parent_approved_idx');
            $table->index(['user_id', 'is_approved'], 'comments_user_approved_idx');
        });

        // Add indexes for categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'categories_active_sort_idx');
            $table->index('slug', 'categories_slug_idx');
        });

        // Add indexes for portfolios table if exists
        if (Schema::hasTable('portfolios')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->index(['is_published', 'created_at'], 'portfolios_published_date_idx');
                $table->index(['is_featured', 'is_published'], 'portfolios_featured_published_idx');
                $table->index('slug', 'portfolios_slug_idx');
            });
        }

        // Add indexes for curator (media) table
        Schema::table('curator', function (Blueprint $table) {
            $table->index('type', 'curator_type_idx');
            $table->index(['disk', 'directory'], 'curator_location_idx');
        });

        // Add indexes for db_config table for settings performance
        Schema::table('db_config', function (Blueprint $table) {
            $table->index(['group', 'key'], 'db_config_group_key_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_published_date_idx');
            $table->dropIndex('posts_featured_published_idx');
            $table->dropIndex('posts_category_published_idx');
            $table->dropIndex('posts_user_published_idx');
            $table->dropIndex('posts_views_idx');
            $table->dropIndex('posts_slug_idx');
            $table->dropFullText('posts_search_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_post_approved_idx');
            $table->dropIndex('comments_parent_approved_idx');
            $table->dropIndex('comments_user_approved_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_active_sort_idx');
            $table->dropIndex('categories_slug_idx');
        });

        if (Schema::hasTable('portfolios')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropIndex('portfolios_published_date_idx');
                $table->dropIndex('portfolios_featured_published_idx');
                $table->dropIndex('portfolios_slug_idx');
            });
        }

        Schema::table('curator', function (Blueprint $table) {
            $table->dropIndex('curator_type_idx');
            $table->dropIndex('curator_location_idx');
        });

        Schema::table('db_config', function (Blueprint $table) {
            $table->dropIndex('db_config_group_key_idx');
        });
    }
};
