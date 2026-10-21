<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sinhala versions of the written content; slugs, images and settings stay shared with English.
     */
    public function up(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('name_si')->nullable()->after('name');
            $table->text('description_si')->nullable()->after('description');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_si')->nullable()->after('title');
            $table->string('meta_title_si')->nullable()->after('meta_title');
            $table->string('meta_description_si', 500)->nullable()->after('meta_description');
            $table->string('meta_keywords_si', 500)->nullable()->after('meta_keywords');
            $table->longText('description_si')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn(['name_si', 'description_si']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['title_si', 'meta_title_si', 'meta_description_si', 'meta_keywords_si', 'description_si']);
        });
    }
};
