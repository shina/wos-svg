<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('screenshots')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->dateTime('solved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
