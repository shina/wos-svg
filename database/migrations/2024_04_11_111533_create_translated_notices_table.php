<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translated_notices', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->text('content');
            $table->boolean('enable_auto_translation')->default(true);
            $table->foreignId('notice_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translated_notices');
    }
};
