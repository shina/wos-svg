<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alliance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
        'state',
        'domain',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => "[$this->acronym] $this->name",
        );
    }
}
