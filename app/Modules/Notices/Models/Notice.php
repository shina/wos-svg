<?php

namespace App\Modules\Notices\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        self::saving(function (Notice $notice) {
            if ($notice->isDirty('title')) {
                $notice->title = strtoupper($notice->title);
            }

            if ($notice->isDirty('content')) {
                // translate into multiple languages
            }
        });
    }
}
