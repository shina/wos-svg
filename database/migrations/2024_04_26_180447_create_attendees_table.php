<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->string('commitment_level');
            $table->string('is_commitment_fulfilled')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('player_id')->constrained();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
