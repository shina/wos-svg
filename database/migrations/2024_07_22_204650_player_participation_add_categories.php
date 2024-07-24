<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_participations', function (Blueprint $table) {
            $table->string('combined_categories')
                ->nullable()
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('player_participations', function (Blueprint $table) {
            $table->dropColumn('combined_categories');
        });
    }
};
