<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class ContactVerificationStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<ContactVerificationStatusChangeEventName> $eventName
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var array<string> $domains
     */
    #[JsonProperty('domains'), ArrayType(['string'])]
    public array $domains;

    /**
     * @var int $verificationId The id of the verification record for the contact. Please note, this is different than the `contact_id` that may be returned in other API contexts. This id specifically relates to the verification and will be different than an `contact_id` for the same contact record in other contexts.
     */
    #[JsonProperty('verificationId')]
    public int $verificationId;

    /**
     * @var ContactVerificationStatusChangeVerification $verification
     */
    #[JsonProperty('verification')]
    public ContactVerificationStatusChangeVerification $verification;

    /**
     * @param array{
     *   eventName: value-of<ContactVerificationStatusChangeEventName>,
     *   domains: array<string>,
     *   verificationId: int,
     *   verification: ContactVerificationStatusChangeVerification,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domains = $values['domains'];
        $this->verificationId = $values['verificationId'];
        $this->verification = $values['verification'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
