<?php

namespace App\Modules\Participation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    protected static function booted()
    {
        self::creating(function (self $eventCategory) {
            if ($eventCategory->isDirty('category')) {
                $eventCategory->category = strtolower($eventCategory->category);
            }
        });
    }
}
