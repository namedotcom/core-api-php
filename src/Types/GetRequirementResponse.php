<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * GetRequirementResponse has TLD Info and registration requirements for the specified TLD. The requirements field will always be present but may be an empty object when no specific requirements exist for the TLD.
 */
class GetRequirementResponse extends JsonSerializableType
{
    /**
     * @var ResellerTldInfo $tldInfo General information about a specific TLD. These are not registration requirements, but contain useful information for domain reseller and domain registrants in general.
     */
    #[JsonProperty('tldInfo')]
    public ResellerTldInfo $tldInfo;

    /**
     * The registration requirements for the contacts for this TLD, including required fields, validation rules, and conditional logic.  This field will always be present but may be an empty object when no specific requirements exist for the TLD.
     * Only a few CC Tlds have specific contact requirements. These contacts must be submitted as part of the domain object when registering a domain, and not part of the `tldRequirements` parameter.
     * Please check the contact requirements carefully, as different fields may be required for different roles, and there may be additional validation rules that must be followed.
     *
     * @var ContactsRequirement $contacts
     */
    #[JsonProperty('contacts')]
    public ContactsRequirement $contacts;

    /**
     * @var Requirement $requirements The registration requirements for this TLD, including required fields, validation rules, and conditional logic. This field will always be present but may be an empty object when no specific requirements exist for the TLD.
     */
    #[JsonProperty('requirements')]
    public Requirement $requirements;

    /**
     * @param array{
     *   tldInfo: ResellerTldInfo,
     *   contacts: ContactsRequirement,
     *   requirements: Requirement,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tldInfo = $values['tldInfo'];
        $this->contacts = $values['contacts'];
        $this->requirements = $values['requirements'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
