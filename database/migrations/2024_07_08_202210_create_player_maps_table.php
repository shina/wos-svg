<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_maps', function (Blueprint $table) {
            $table->id();
            $table->integer('coordinate_position');
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
        });
    }
};
