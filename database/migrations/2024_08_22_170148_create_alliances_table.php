<?php

use App\Models\Alliance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alliances', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('acronym')->unique();
            $table->string('state');
            $table->string('domain')->unique()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Alliance::create([
            'name' => 'Savages',
            'acronym' => 'SVG',
            'state' => '418',
            'domain' => 'svg.servegame.com',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('alliances');
    }
};
