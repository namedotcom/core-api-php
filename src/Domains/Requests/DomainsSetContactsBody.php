<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\ContactsRequest;
use Namecom\Core\Json\JsonProperty;

class DomainsSetContactsBody extends JsonSerializableType
{
    /**
     * @var ?ContactsRequest $contacts
     */
    #[JsonProperty('contacts')]
    public ?ContactsRequest $contacts;

    /**
     * @param array{
     *   contacts?: ?ContactsRequest,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->contacts = $values['contacts'] ?? null;
    }
}
