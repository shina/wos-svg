<?php

namespace App\Modules\Participation\Services\CalculateTrustLevel;

use Illuminate\Database\Eloquent\Builder;

interface QueryModifier
{
    public function modifyQuery(Builder $query): Builder;
}
