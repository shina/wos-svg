<?php

namespace App\Modules\Wiki;

use App\Modules\Wiki\database\factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function newFactory()
    {
        return PageFactory::new();
    }

    public function translatedPages(): HasMany
    {
        return $this->hasMany(TranslatedPage::class, 'page_id');
    }
}
