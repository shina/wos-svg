<?php

use App\Models\Alliance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internal_notes', function (Blueprint $table) {
            $table->foreignIdFor(Alliance::class)
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('internal_notes', function (Blueprint $table) {
            $table->dropForeignIdFor(Alliance::class);
            $table->dropColumn('alliance_id');
        });
    }
};
