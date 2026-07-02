<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Response for resending a contact verification email.
 */
class ContactVerificationResendResponse extends JsonSerializableType
{
    /**
     * @var bool $sent Whether a verification email was sent as a result of this request.
     */
    #[JsonProperty('sent')]
    public bool $sent;

    /**
     * @var int $verificationId The verificationId for the contact verification record.
     */
    #[JsonProperty('verificationId')]
    public int $verificationId;

    /**
     * @var DateTime $nextEligibleAt When the client can attempt to resend again, as an RFC3339/ISO-8601 UTC timestamp. This field is always returned, including when throttling applies.
     */
    #[JsonProperty('nextEligibleAt'), Date(Date::TYPE_DATETIME)]
    public DateTime $nextEligibleAt;

    /**
     * @param array{
     *   sent: bool,
     *   verificationId: int,
     *   nextEligibleAt: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->sent = $values['sent'];
        $this->verificationId = $values['verificationId'];
        $this->nextEligibleAt = $values['nextEligibleAt'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
