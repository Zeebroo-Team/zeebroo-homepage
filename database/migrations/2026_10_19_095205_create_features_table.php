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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('menu')->nullable();
            $table->string('icon', 64)->default('fa-puzzle-piece');
            $table->string('group', 16)->default('suite');
            $table->string('badge', 32)->nullable();
            $table->string('headline')->nullable();
            $table->text('lead')->nullable();
            $table->json('highlights')->nullable();
            $table->json('capabilities')->nullable();
            $table->string('spot_path')->nullable();
            $table->string('scene_path')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
