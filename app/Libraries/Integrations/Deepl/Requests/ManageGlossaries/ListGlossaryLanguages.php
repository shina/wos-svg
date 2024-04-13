<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * listGlossaryLanguages
 *
 * Retrieve the list of language pairs supported by the glossary feature.
 */
class ListGlossaryLanguages extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/glossary-language-pairs';
    }

    public function __construct()
    {
    }
}
