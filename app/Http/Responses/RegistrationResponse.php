<?php

namespace App\Http\Responses;

class RegistrationResponse implements \Filament\Http\Responses\Auth\Contracts\RegistrationResponse
{
    public function toResponse($request)
    {
        return redirect(route('new-user-welcome'));
    }
}
