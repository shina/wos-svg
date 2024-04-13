<?php

namespace App\Libraries\Integrations\Deepl;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

/**
 * DeepL API Documentation
 *
 * The DeepL API provides programmatic access to DeepL’s machine translation technology.
 */
class Deepl extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api-free.deepl.com/v2';
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(config('auth.deepl.api-key'), 'DeepL-Auth-Key');
    }
}
