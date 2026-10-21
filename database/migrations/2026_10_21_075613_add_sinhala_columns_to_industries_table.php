<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sinhala versions of the written content; slugs, icons, images and settings stay shared with English.
     * highlights_si rows line up by index with highlights, which keep the icon.
     */
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->string('title_si')->nullable()->after('title');
            $table->string('menu_si')->nullable()->after('menu');
            $table->string('badge_si', 32)->nullable()->after('badge');
            $table->string('headline_si')->nullable()->after('headline');
            $table->text('lead_si')->nullable()->after('lead');
            $table->json('highlights_si')->nullable()->after('highlights');
            $table->json('capabilities_si')->nullable()->after('capabilities');
            $table->string('meta_title_si')->nullable()->after('meta_title');
            $table->string('meta_description_si', 500)->nullable()->after('meta_description');
            $table->string('meta_keywords_si', 500)->nullable()->after('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->dropColumn([
                'title_si', 'menu_si', 'badge_si', 'headline_si', 'lead_si', 'highlights_si', 'capabilities_si',
                'meta_title_si', 'meta_description_si', 'meta_keywords_si',
            ]);
        });
    }
};
