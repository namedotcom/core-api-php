<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * A list of unverified contacts that relate to your account.
 */
class UnverifiedContactsResponse extends JsonSerializableType
{
    /**
     * @var array<UnverifiedContact> $unverifiedContacts
     */
    #[JsonProperty('unverifiedContacts'), ArrayType([UnverifiedContact::class])]
    public array $unverifiedContacts;

    /**
     * @var int $from From is the starting record for the current page.
     */
    #[JsonProperty('from')]
    public int $from;

    /**
     * @var int $to To is the ending record for the current page.
     */
    #[JsonProperty('to')]
    public int $to;

    /**
     * @var int $lastPage LastPage is the identifier for the final page of results. This value will be null if there is not a previous result page.
     */
    #[JsonProperty('lastPage')]
    public int $lastPage;

    /**
     * @var ?int $nextPage NextPage is the identifier for the next page of results. This value will be null if there is not a next page of results.
     */
    #[JsonProperty('nextPage')]
    public ?int $nextPage;

    /**
     * @var int $totalCount TotalCount is total number of domains returned for request.
     */
    #[JsonProperty('totalCount')]
    public int $totalCount;

    /**
     * @param array{
     *   unverifiedContacts: array<UnverifiedContact>,
     *   from: int,
     *   to: int,
     *   lastPage: int,
     *   totalCount: int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->unverifiedContacts = $values['unverifiedContacts'];
        $this->from = $values['from'];
        $this->to = $values['to'];
        $this->lastPage = $values['lastPage'];
        $this->nextPage = $values['nextPage'] ?? null;
        $this->totalCount = $values['totalCount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
