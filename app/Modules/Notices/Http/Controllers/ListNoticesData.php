<?php

namespace App\Modules\Notices\Http\Controllers;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class ListNoticesData extends Data
{
    /**
     * @param  Collection<NoticeData>  $notices
     */
    public function __construct(
        public Collection $notices
    ) {
    }

    public static function fromCollection(Collection $notices): self
    {
        return new self(NoticeData::collect($notices));
    }
}
