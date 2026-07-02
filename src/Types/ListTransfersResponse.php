<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListTransfersResponse returns the list of pending transfers as well as the pagination information if relevant.
 */
class ListTransfersResponse extends JsonSerializableType
{
    /**
     * @var ?int $lastPage LastPage is the identifier for the final page of results. It is only populated if there is another page of results after the current page.
     */
    #[JsonProperty('lastPage')]
    public ?int $lastPage;

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
     * @var array<Transfer> $transfers Transfers is a list of pending transfers
     */
    #[JsonProperty('transfers'), ArrayType([Transfer::class])]
    public array $transfers;

    /**
     * @param array{
     *   totalCount: int,
     *   from: int,
     *   to: int,
     *   transfers: array<Transfer>,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
        $this->totalCount = $values['totalCount'];
        $this->from = $values['from'];
        $this->to = $values['to'];
        $this->transfers = $values['transfers'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
