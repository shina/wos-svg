<?php

namespace App\Modules\Participation;

use App\Modules\Participation\ModelFactories\EventCategoryFactory;
use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventCategory extends Model
{
    use BelongsToAlliance;
    use HasFactory;

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

    protected static function newFactory()
    {
        return EventCategoryFactory::new();
    }
}
