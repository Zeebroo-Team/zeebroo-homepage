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
        Schema::create('doc_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_page_id')->constrained()->cascadeOnDelete();
            $table->string('anchor');
            $table->string('heading');
            $table->string('heading_si')->nullable();
            $table->longText('body')->nullable();
            $table->longText('body_si')->nullable();
            $table->boolean('is_custom')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['doc_page_id', 'anchor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_sections');
    }
};
