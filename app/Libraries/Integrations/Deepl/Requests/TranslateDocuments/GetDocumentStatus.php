<?php

namespace App\Libraries\Integrations\Deepl\Requests\TranslateDocuments;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * getDocumentStatus
 */
class GetDocumentStatus extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/document/{$this->documentId}";
    }

    /**
     * @param  string  $documentId  The document ID that was sent to the client when the document was uploaded to the API.
     */
    public function __construct(
        protected string $documentId,
    ) {
    }
}
