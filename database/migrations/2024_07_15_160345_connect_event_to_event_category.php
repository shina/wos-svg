<?php

use App\Modules\Participation\EventCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_event_category', function (Blueprint $table) {
            $table->foreignIdFor(\App\Modules\Participation\Event::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(EventCategory::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_event_category');
    }
};
