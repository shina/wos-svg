<?php

namespace App\Libraries\Integrations\Deepl\Requests\ManageGlossaries;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * deleteGlossary
 *
 * Deletes the specified glossary.
 */
class DeleteGlossary extends Request
{
    protected Method $method = Method::DELETE;

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
