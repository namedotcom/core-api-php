<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * SearchResponse returns a list of search results.
 */
class SearchResponse extends JsonSerializableType
{
    /**
     * @var ?array<SearchResult> $results Results of the search are returned here, the order should not be relied upon.
     */
    #[JsonProperty('results'), ArrayType([SearchResult::class])]
    public ?array $results;

    /**
     * @param array{
     *   results?: ?array<SearchResult>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->results = $values['results'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
