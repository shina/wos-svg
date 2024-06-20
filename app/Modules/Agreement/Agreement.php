<?php

namespace App\Modules\Agreement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'options',
    ];

    protected function casts()
    {
        return [
            'options' => 'array',
        ];
    }

    public function respondents(): HasMany
    {
        return $this->hasMany(Respondent::class);
    }
}
