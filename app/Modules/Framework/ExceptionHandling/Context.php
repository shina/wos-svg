<?php

namespace App\Modules\Framework\ExceptionHandling;

class Context
{
    public function __invoke(): array
    {
        return match (app()->runningInConsole()) {
            true => $this->console(),
            false => $this->webOrApi(),
        };
    }

    private function webOrApi(): array
    {
        return [
            'request' => [
                'params' => request()->all(),
                'route' => request()->route()->uri,
            ],
        ];
    }

    private function console()
    {
        return [];
    }
}
