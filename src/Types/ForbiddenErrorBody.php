<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class ForbiddenErrorBody extends JsonSerializableType
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
