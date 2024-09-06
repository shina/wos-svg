<?php

namespace App\View\Components;

use App\Data\PathData;
use App\Models\Alliance;
use Illuminate\View\Component;
use Illuminate\View\View;

class Layout extends Component
{
    public function render(): View
    {
        $alliance = Alliance::find(allianceId());

        $large = PathData::from($alliance->logo);
        $large->filename .= '-large';

        $medium = PathData::from($alliance->logo);
        $medium->filename .= '-medium';

        $small = PathData::from($alliance->logo);
        $small->filename .= '-small';

        return view('components.layout', [
            'data' => LayoutData::from([
                'acronym' => $alliance->acronym,
                'logo' => [
                    'large' => $large->toString(),
                    'medium' => $medium->toString(),
                    'small' => $small->toString(),
                ],
            ]),
        ]);
    }
}
