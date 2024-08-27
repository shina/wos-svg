<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class Alliance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
        'state',
        'domain',
    ];

    protected static function booted()
    {
        self::saved(function () {
            Alliance::pluck('id')->each(function (int $allianceId) {
                Permission::createOrFirst(['name' => "access alliance-id $allianceId"]);
            });
        });
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => "[$this->acronym] $this->name",
        );
    }
}
