<?php

namespace App\Modules\Wiki\Models;

use App\Modules\Wiki\database\factories\PageFactory;
use App\Modules\Wiki\Services\RouteSlugsRegex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function newFactory()
    {
        return PageFactory::new();
    }

    protected static function booted()
    {
        self::saving(function (self $page) {
            resolve(RouteSlugsRegex::class)->flushCache();
        });
    }
}
