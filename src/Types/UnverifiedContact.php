<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;
use Namecom\Core\Types\ArrayType;

/**
 * The pertinent information used to identifiy a domain contact that requires verification as per ICANN requirements.
 */
class UnverifiedContact extends JsonSerializableType
{
    /**
     * @var int $verificationId The id of the verification record for the contact. Please note, this is different than the `contact_id` that may be returned in other API contexts. This id specifically relates to the verification record and will be different than a `contact_id` for the same contact record in other contexts.
     */
    #[JsonProperty('verificationId')]
    public int $verificationId;

    /**
     * @var ?DateTime $createDate The date the record requiring verification was created.
     */
    #[JsonProperty('createDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createDate;

    /**
     * @var ?DateTime $verifyBy The date/time that the contact record **must** be verified by.  If the contact record is not verified by this date, the domain may become locked by the registry. This is typically 15 days from the creation date of the verification record, but may vary by TLD and registry.
     */
    #[JsonProperty('verifyBy'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $verifyBy;

    /**
     * @var ?string $email The email address of the contact to be verified. This is the primary identifier used for verification.
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var array<string> $domains A list of the domains that the contact verification record is applied to.
     */
    #[JsonProperty('domains'), ArrayType(['string'])]
    public array $domains;

    /**
     * @param array{
     *   verificationId: int,
     *   domains: array<string>,
     *   createDate?: ?DateTime,
     *   verifyBy?: ?DateTime,
     *   email?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->verificationId = $values['verificationId'];
        $this->createDate = $values['createDate'] ?? null;
        $this->verifyBy = $values['verifyBy'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->domains = $values['domains'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
