<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * Optional transfer warnings surfaced by the API when non-blocking registry statuses are detected.
 */
class CreateTransferResponseWarnings extends JsonSerializableType
{
    /**
     * @var ?string $message Brief guidance for resolving potential transfer issues.
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?array<string> $statuses Registry status values that triggered the warning.
     */
    #[JsonProperty('statuses'), ArrayType(['string'])]
    public ?array $statuses;

    /**
     * @param array{
     *   message?: ?string,
     *   statuses?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->message = $values['message'] ?? null;
        $this->statuses = $values['statuses'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
