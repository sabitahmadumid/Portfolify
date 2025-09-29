<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing foreign key constraints that reference curator table
        DB::statement('ALTER TABLE posts DROP FOREIGN KEY posts_featured_image_id_foreign');
        DB::statement('ALTER TABLE portfolios DROP FOREIGN KEY portfolios_featured_image_id_foreign');
        DB::statement('ALTER TABLE categories DROP FOREIGN KEY categories_featured_image_id_foreign');
        
        Schema::create('curator', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('disk');
            $table->string('directory')->nullable();
            $table->string('visibility')->default('public');
            $table->string('name');
            $table->string('path')->index();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->string('type');
            $table->string('ext');
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('caption')->nullable();
            $table->text('pretty_name')->nullable();
            $table->text('exif')->nullable();
            $table->longText('curations')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable()->index();

            $table->timestamps();
        });
        
        // Change the featured_image_id columns to match curator's uuid primary key
        DB::statement('ALTER TABLE posts MODIFY featured_image_id CHAR(36) NULL');
        DB::statement('ALTER TABLE portfolios MODIFY featured_image_id CHAR(36) NULL');
        DB::statement('ALTER TABLE categories MODIFY featured_image_id CHAR(36) NULL');
        
        // Recreate foreign key constraints with correct data types
        DB::statement('ALTER TABLE posts ADD CONSTRAINT posts_featured_image_id_foreign FOREIGN KEY (featured_image_id) REFERENCES curator(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE portfolios ADD CONSTRAINT portfolios_featured_image_id_foreign FOREIGN KEY (featured_image_id) REFERENCES curator(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE categories ADD CONSTRAINT categories_featured_image_id_foreign FOREIGN KEY (featured_image_id) REFERENCES curator(id) ON DELETE SET NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('curator');
    }
};
