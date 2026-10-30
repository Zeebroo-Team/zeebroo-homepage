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
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_si')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_description_si', 500)->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('og_image_alt')->nullable();
            $table->string('og_image_alt_si')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
