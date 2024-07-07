<?php

use App\Modules\Map\MapProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    \App\Modules\Notices\NoticesProvider::class,
    \App\Modules\Wiki\WikiProvider::class,
    \App\Modules\Framework\LocaleSelection\LocaleSelectionProvider::class,
    \App\Modules\Players\PlayersProvider::class,
    \App\Modules\Participation\ParticipationProvider::class,
    MapProvider::class,
];
