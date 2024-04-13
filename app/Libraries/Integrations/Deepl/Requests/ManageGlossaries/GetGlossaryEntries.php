<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getGlossaryEntries
 *
 * List the entries of a single glossary in the format specified by the `Accept` header.
 */
class GetGlossaryEntries extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/glossaries/{$this->glossaryId}/entries";
    }

    /**
     * @param  string  $glossaryId  A unique ID assigned to the glossary.
     */
    public function __construct(
        protected string $glossaryId,
    ) {
    }
}
