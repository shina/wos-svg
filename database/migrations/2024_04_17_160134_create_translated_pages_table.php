<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translated_pages', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->string('language');
            $table->boolean('enable_auto_translation');
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translated_pages');
    }
};
