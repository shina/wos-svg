<?php

namespace App\Modules\Notices\Http\Controllers;

use App\Modules\Notices\Models\Notice;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class NoticeData extends Data
{

    #[Computed]
    public string $slug;

    public function __construct(
        public string $title,
        public string $content,
    ) {
        $this->slug = Str::slug($title);
        $this->content = nl2br($this->content);
    }

}
