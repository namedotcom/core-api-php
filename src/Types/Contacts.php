<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Contacts stores the contact information for the roles related to domains.
 */
class Contacts extends JsonSerializableType
{
    /**
     * @var ?Contact $admin
     */
    #[JsonProperty('admin')]
    public ?Contact $admin;

    /**
     * @var ?Contact $billing
     */
    #[JsonProperty('billing')]
    public ?Contact $billing;

    /**
     * @var ?RegistrantContact $registrant
     */
    #[JsonProperty('registrant')]
    public ?RegistrantContact $registrant;

    /**
     * @var ?Contact $tech
     */
    #[JsonProperty('tech')]
    public ?Contact $tech;

    /**
     * @param array{
     *   admin?: ?Contact,
     *   billing?: ?Contact,
     *   registrant?: ?RegistrantContact,
     *   tech?: ?Contact,
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
