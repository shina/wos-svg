<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BelongsToAllianceScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('alliance_id', allianceId());
    }

    public function extend(Builder $builder)
    {
        $builder->macro('onlyAllianceOrphan', function (Builder $builder) {
            return $builder
                ->withoutGlobalScope($this)
                ->whereNull('alliance_id');
        });
    }
}
