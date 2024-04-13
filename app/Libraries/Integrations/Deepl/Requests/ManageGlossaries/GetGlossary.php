<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getGlossary
 *
 * Retrieve meta information for a single glossary, omitting the glossary entries.
 */
class GetGlossary extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/glossaries/{$this->glossaryId}";
    }

    /**
     * @param  string  $glossaryId  A unique ID assigned to the glossary.
     */
    public function __construct(
        protected string $glossaryId,
    ) {
    }
}
