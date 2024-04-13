<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * listGlossaries
 *
 * List all glossaries and their meta-information, but not the glossary entries.
 */
class ListGlossaries extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/glossaries';
    }

    public function __construct()
    {
    }
}
