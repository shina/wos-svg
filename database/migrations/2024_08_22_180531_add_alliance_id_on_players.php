<?php

use App\Models\Alliance;
use App\Models\Player;
use App\Models\Scopes\BelongsToAllianceScope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->foreignIdFor(Alliance::class)
                ->default(1)
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        Player::withoutGlobalScope(BelongsToAllianceScope::class)
            ->onlyTrashed()
            ->update(['alliance_id' => null]);
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropForeignIdFor(Alliance::class);
            $table->dropColumn('alliance_id');
        });
    }
};
