<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Contacts stores the contact information for the roles related to domains. This schema is used for requests.
 */
class ContactsRequest extends JsonSerializableType
{
    /**
     * @var ?ContactRequest $admin
     */
    #[JsonProperty('admin')]
    public ?ContactRequest $admin;

    /**
     * @var ?ContactRequest $billing
     */
    #[JsonProperty('billing')]
    public ?ContactRequest $billing;

    /**
     * @var ?RegistrantContactRequest $registrant
     */
    #[JsonProperty('registrant')]
    public ?RegistrantContactRequest $registrant;

    /**
     * @var ?ContactRequest $tech
     */
    #[JsonProperty('tech')]
    public ?ContactRequest $tech;

    /**
     * @param array{
     *   admin?: ?ContactRequest,
     *   billing?: ?ContactRequest,
     *   registrant?: ?RegistrantContactRequest,
     *   tech?: ?ContactRequest,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->admin = $values['admin'] ?? null;
        $this->billing = $values['billing'] ?? null;
        $this->registrant = $values['registrant'] ?? null;
        $this->tech = $values['tech'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
