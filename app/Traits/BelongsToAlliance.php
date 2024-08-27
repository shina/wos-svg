<?php

namespace App\Traits;

use App\Models\Scopes\BelongsToAllianceScope;

trait BelongsToAlliance
{
    public static function bootBelongsToAlliance()
    {
        if (app()->runningInConsole()) {
            return;
        }

        static::addGlobalScope(new BelongsToAllianceScope);

        static::creating(function ($model) {
            $model->alliance_id = allianceId();
        });
    }
}
