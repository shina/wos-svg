<?php

use App\Models\Alliance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_categories', function (Blueprint $table) {
            $table->foreignIdFor(Alliance::class)
                ->default(1)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->dropUnique('event_categories_category_unique');
            $table->unique(['category', 'alliance_id']);
        });
    }

    public function down(): void
    {
        Schema::table('event_categories', function (Blueprint $table) {
            $table->dropForeignIdFor(Alliance::class);
            $table->dropColumn('alliance_id');
        });
    }
};
