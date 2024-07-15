<?php

namespace App\Modules\InternalNotes;

use Illuminate\Database\Eloquent\Model;

class InternalNote extends Model
{
    protected $fillable = [
        'content',
    ];
}
