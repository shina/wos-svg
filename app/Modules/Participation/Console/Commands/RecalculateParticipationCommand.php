<?php

namespace App\Modules\Participation\Console\Commands;

use App\Modules\Participation\Jobs\RecalculateAllPlayersJob;
use Illuminate\Console\Command;

class RecalculateParticipationCommand extends Command
{
    protected $signature = 'participation:recalculate';

    protected $description = 'Start the calculation of the participation on each player';

    public function handle(): void
    {
        info('Starting calculation...');
        RecalculateAllPlayersJob::dispatch();
    }
}
