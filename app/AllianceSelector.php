<?php

namespace App;

use App\Models\Alliance;
use Error;
use Illuminate\Log\Context\Repository;

class AllianceSelector
{
    public function __construct(
        private Repository $contextRepository,
    ) {}

    public function select(Alliance $alliance)
    {
        config()->set('app.name', $alliance->name);
        $this->contextRepository->add('alliance_id', $alliance->id);
    }

    public function getSelected(): int
    {
        $allianceId = $this->contextRepository->get('alliance_id');
        throw_if($allianceId === null, Error::class, 'Alliance is not setup yet');

        return $allianceId;
    }
}
