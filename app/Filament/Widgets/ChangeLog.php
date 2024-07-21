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
                    'title' => 'Different colors on map spots',
                    'date' => '21.07.2024',
                ]),
                ChangeData::from([
                    'isNew' => true,
                    'title' => 'Internal notes',
                    'date' => '21.07.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add list of event for a player',
                    'date' => '11.07.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add Map manager',
                    'date' => '10.07.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add Report button in agreements section',
                    'date' => '27.06.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Fix participation sorting',
                    'date' => '26.06.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add agreements',
                    'date' => '20.06.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add 3 types of participation rate: 3 last events, 1 month and all the time',
                    'date' => '17.06.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Fix the notice character validation',
                    'date' => '10.06.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add button to add all remaining players in an event',
                    'date' => '26.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Remove commitment level (join, absent) on event attendees',
                    'date' => '26.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add Players Participation for having an overview of all players.',
                    'date' => '26.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Add translated nickname to Players. This will be helpful for names that use non-Roman characters.',
                    'date' => '02.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added issue tracker',
                    'date' => '01.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
                    'title' => 'Added participation rate level (list of attendees in events)',
                    'date' => '01.05.2024',
                ]),
                ChangeData::from([
                    'isNew' => false,
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
