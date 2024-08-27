<?php

namespace App\Modules\Participation\Console\Commands;

use App\Modules\Participation\Jobs\RecauculateAllAlliancesJob;
use Illuminate\Console\Command;

class RecalculateParticipationCommand extends Command
{
    protected $signature = 'participation:recalculate';

    protected $description = 'Start the calculation of the participation on each player';

    public function handle(): void
    {
        $this->info('Starting calculation...');
        logger()->info('Starting calculation...');

        dispatch_sync(new RecauculateAllAlliancesJob);

        $this->info('Finished');
        logger()->info('Finished');
    }
}
