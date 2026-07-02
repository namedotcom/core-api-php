<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * Response for checking domain availability via DNS zone checks.
 */
class ZoneCheckResponse extends JsonSerializableType
{
    /**
     * @var array<ZoneCheckResult> $results
     */
    #[JsonProperty('results'), ArrayType([ZoneCheckResult::class])]
    public array $results;

    /**
     * @var int $total Total number of records checked
     */
    #[JsonProperty('total')]
    public int $total;

    /**
     * @var ?int $removed Number of domain strings removed during pre-validation (invalid format, unsupported TLD for this service, etc.). This is a count only;  the response does not list which strings were removed.
     */
    #[JsonProperty('removed')]
    public ?int $removed;

    /**
     * @param array{
     *   results: array<ZoneCheckResult>,
     *   total: int,
     *   removed?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->results = $values['results'];
        $this->total = $values['total'];
        $this->removed = $values['removed'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
