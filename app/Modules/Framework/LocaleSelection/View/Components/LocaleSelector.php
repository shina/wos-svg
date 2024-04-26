<?php

namespace App\Modules\Framework\LocaleSelection\View\Components;

use App\Enums\Language;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LocaleSelector extends Component
{
    public function render(): View
    {
        $selectedLanguage = app()->getLocale();

        return view(
            'locale-selection::components.locale-selector',
            ['data' => LocaleSelectorData::from(Language::collect(), $selectedLanguage)->toArray()]
        );
    }
}
