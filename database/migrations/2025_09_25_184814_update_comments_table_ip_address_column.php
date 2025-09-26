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
        Schema::table('comments', function (Blueprint $table) {
            $table->ipAddress('ip_address')->nullable()->change();
            $table->text('user_agent')->nullable()->change();
            
            // Add indexes for better performance
            $table->index(['post_id', 'is_approved']);
            $table->index(['parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['post_id', 'is_approved']);
            $table->dropIndex(['parent_id']);
        });
    }
};
