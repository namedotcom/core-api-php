<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * A conflict error response.
 */
class GenericConflict409 extends JsonSerializableType
{
    /**
     * @var string $message A human-readable error message describing the conflict
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
