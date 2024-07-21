<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_maps', function (Blueprint $table) {
            $table->boolean('is_correct')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('player_maps', function (Blueprint $table) {
            $table->dropColumn('is_correct');
        });
    }
};
