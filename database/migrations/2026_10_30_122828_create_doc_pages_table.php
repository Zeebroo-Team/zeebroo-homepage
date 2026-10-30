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
        Schema::create('doc_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_group_id')->constrained()->restrictOnDelete();
            $table->string('slug')->unique();
            $table->string('number', 16);
            $table->string('icon', 64)->default('fa-book');
            $table->string('title');
            $table->string('title_si')->nullable();
            $table->string('description', 500);
            $table->string('description_si', 500)->nullable();
            $table->longText('intro')->nullable();
            $table->longText('intro_si')->nullable();
            $table->longText('outro')->nullable();
            $table->longText('outro_si')->nullable();
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
        Schema::dropIfExists('doc_pages');
    }
};
