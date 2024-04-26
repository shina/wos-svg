<?php

namespace App\Modules\Participation;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected function casts()
    {
        return [
            'date' => 'date',
        ];
    }
}
