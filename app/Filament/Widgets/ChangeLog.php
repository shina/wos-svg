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
                    'title' => 'Add translated nickname to Players. This will be helpful for names that use non-Roman characters.',
                    'date' => '02.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Added issue tracker',
                    'date' => '01.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Added participation rate level (list of attendees in events)',
                    'date' => '01.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Small features and fixes',
                    'description' => 'Players can be searched by ID; Players are sorted by rating by default; And more...',
                    'date' => '01.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added event logging to track which players attended each event.',
                    'date' => '29.04.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added bulk action to change Players rank',
                    'date' => '26.04.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added this change log widget 🙂',
                    'date' => '21.04.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added a button to display the most recent comments on the Players page',
                    //                    'description' => '',
                    'date' => '21.04.2024',
                ]),
            ],
        ];
    }
}
