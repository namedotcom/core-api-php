<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Error response returned when a resource is locked and cannot be modified. Used when the Add Grace Period (AGP) deletion window has expired.
 */
class Locked423 extends JsonSerializableType
{
    /**
     * @var string $message A human-readable message providing more details about the error
     */
    #[JsonProperty('message')]
    public string $message;

    /**
     * @var ?string $details Additional context or information about the error
     */
    #[JsonProperty('details')]
    public ?string $details;

    /**
     * @param array{
     *   message: string,
     *   details?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->message = $values['message'];
        $this->details = $values['details'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
