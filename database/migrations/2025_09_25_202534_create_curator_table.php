<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curator', function (Blueprint $table) {
            $table->id();

            $table->string('disk')->default('public');
            $table->string('directory')->nullable();
            $table->string('visibility')->default('public');
            $table->string('name')->default('');
            $table->string('path')->index()->default('');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->string('type')->default('');
            $table->string('ext')->default('');
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('caption')->nullable();
            $table->text('pretty_name')->nullable();
            $table->text('exif')->nullable();
            $table->longText('curations')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curator');
    }
};
