<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class TldPriceListResponse extends JsonSerializableType
{
    /**
     * @var int $lastPage LastPage is the identifier for the final page of results. It is only populated if there is another page of results after the current page.
     */
    #[JsonProperty('lastPage')]
    public int $lastPage;

    /**
     * @var ?int $nextPage NextPage is the identifier for the next page of results. It is only populated if there is another page of results after the current page.
     */
    #[JsonProperty('nextPage')]
    public ?int $nextPage;

    /**
     * @var int $totalCount TotalCount is total number of results.
     */
    #[JsonProperty('totalCount')]
    public int $totalCount;

    /**
     * @var int $from From specifies starting record number on current page.
     */
    #[JsonProperty('from')]
    public int $from;

    /**
     * @var int $to To specifies ending record number on current page.
     */
    #[JsonProperty('to')]
    public int $to;

    /**
     * @var array<TldPriceListEntry> $pricing
     */
    #[JsonProperty('pricing'), ArrayType([TldPriceListEntry::class])]
    public array $pricing;

    /**
     * @param array{
     *   lastPage: int,
     *   totalCount: int,
     *   from: int,
     *   to: int,
     *   pricing: array<TldPriceListEntry>,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->lastPage = $values['lastPage'];
        $this->nextPage = $values['nextPage'] ?? null;
        $this->totalCount = $values['totalCount'];
        $this->from = $values['from'];
        $this->to = $values['to'];
        $this->pricing = $values['pricing'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
