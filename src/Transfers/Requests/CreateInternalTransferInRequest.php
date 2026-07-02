<?php

namespace Namecom\Transfers\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Types\ContactsRequest;

class CreateInternalTransferInRequest extends JsonSerializableType
{
    /**
     * @var string $domainName Fully qualified domain name to transfer in. The domain must be registered in another name.com account (the losing account).
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var string $authCode Transfer authorization code (EPP/auth code) for the domain. The losing account holder must obtain this code from the [name.com](https://www.name.com) dashboard; it is not exposed by this API for the losing account.
     */
    #[JsonProperty('authCode')]
    public string $authCode;

    /**
     * @var ?ContactsRequest $contacts WHOIS contacts to apply after the transfer. If omitted, the gaining account's default contacts are applied. If provided, include any roles to override; omitted roles use the gaining account's default contacts. Each supplied role must include complete contact fields. A registrar contact-change transfer lock may apply according to the gaining account's settings, consistent with the Set Contacts endpoint.
     */
    #[JsonProperty('contacts')]
    public ?ContactsRequest $contacts;

    /**
     * @param array{
     *   domainName: string,
     *   authCode: string,
     *   contacts?: ?ContactsRequest,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->authCode = $values['authCode'];
        $this->contacts = $values['contacts'] ?? null;
    }
}
