<?php

use App\Models\Alliance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_maps', function (Blueprint $table) {
            $table->foreignIdFor(Alliance::class)
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('player_maps', function (Blueprint $table) {
            $table->dropForeignIdFor(Alliance::class);
            $table->dropColumn('alliance_id');
        });
    }
};
