<?php

namespace App\Traits;

use App\Models\Scopes\BelongsToAllianceScope;

trait BelongsToAlliance
{
    public static function bootBelongsToAlliance()
    {
        static::addGlobalScope(new BelongsToAllianceScope);
    }
}
