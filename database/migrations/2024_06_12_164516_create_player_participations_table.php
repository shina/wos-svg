<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();

            $table->float('last_3_events')
                ->nullable()
                ->index();

            $table->float('one_month')
                ->nullable()
                ->index();

            $table->float('all_time')
                ->nullable()
                ->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_participations');
    }
};
