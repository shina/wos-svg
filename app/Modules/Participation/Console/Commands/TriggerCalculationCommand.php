<?php

namespace App\Modules\Participation\Console\Commands;

use App\Modules\Participation\Jobs\RecalculateAllPlayersJob;
use Illuminate\Console\Command;

class TriggerCalculationCommand extends Command
{
    protected $signature = 'participation:trigger-calculation';

    protected $description = 'Start the calculation of the participation on each player';

    public function handle(): void
    {
        info('Starting calculation...');
        RecalculateAllPlayersJob::dispatch();
    }
}
