<?php

namespace App\Modules\Framework\LocaleSelection\Http\Controllers;

use App\Http\Controllers\Controller;

class ChangeLocaleController extends Controller
{
    public function __invoke(ChangeLocaleRequestData $requestData)
    {
        session()->put(
            config('locale-selection.session-name'),
            $requestData->locale
        );

        return response(status: 200);
    }
}
