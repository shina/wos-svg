<?php

namespace App\Modules\Participation;

use App\Modules\Participation\ModelFactories\EventFactory;
use App\Traits\BelongsToAlliance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use BelongsToAlliance;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'date',
        'created_at',
        'updated_at',
    ];

    protected function casts()
    {
        return [
            'date' => 'date:Y-m-d',
        ];
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(EventCategory::class);
    }

    protected static function newFactory()
    {
        return EventFactory::new();
    }
}
