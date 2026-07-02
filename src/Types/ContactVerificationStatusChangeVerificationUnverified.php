<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use DateTime;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\Date;

class ContactVerificationStatusChangeVerificationUnverified extends JsonSerializableType
{
    /**
     * @var DateTime $verifyBy The date when the contact should be verified by.
     */
    #[JsonProperty('verifyBy'), Date(Date::TYPE_DATETIME)]
    public DateTime $verifyBy;

    /**
     * @param array{
     *   verifyBy: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->verifyBy = $values['verifyBy'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
