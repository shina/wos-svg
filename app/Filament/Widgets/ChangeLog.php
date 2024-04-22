<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ChangeLog extends Widget
{
    protected static string $view = 'filament.widgets.change-log';

    protected function getViewData(): array
    {
        return [
            'changes' => [
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Added this change log widget 🙂',
                    'date' => '21.04.2024',
                ]),
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Added a button to display the most recent comments on the Players page',
                    //                    'description' => '',
                    'date' => '21.04.2024',
                ]),
            ],
        ];
    }
}
