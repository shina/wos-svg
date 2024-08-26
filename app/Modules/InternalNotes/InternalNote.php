<?php

namespace App\Modules\InternalNotes;

use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Model;

class InternalNote extends Model
{
    use BelongsToAlliance;

    protected $fillable = [
        'content',
    ];
}
