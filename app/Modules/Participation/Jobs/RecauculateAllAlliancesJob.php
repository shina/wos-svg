<?php

namespace App\Modules\Participation\Jobs;

use App\AllianceSelector;
use App\Models\Alliance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecauculateAllAlliancesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(AllianceSelector $allianceSelector): void
    {
        Alliance::each(function (Alliance $alliance) {
            return dispatch_sync(new RecalculateAllPlayersJob($alliance->id));
        });
    }
}
