<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class UnavailableForLegal451 extends JsonSerializableType
{
    /**
     * @var string $message A human-readable message explaining why the resource is unavailable for legal reasons
     */
    #[JsonProperty('message')]
    public string $message;

    /**
     * @var ?string $details Additional context or information about the legal restriction
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
