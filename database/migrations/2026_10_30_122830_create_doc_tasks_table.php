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
        Schema::create('doc_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_page_id')->constrained()->restrictOnDelete();
            $table->string('anchor');
            $table->string('icon', 64)->default('fa-check');
            $table->string('title');
            $table->string('title_si')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_tasks');
    }
};
