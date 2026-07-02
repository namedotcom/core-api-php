<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListDomainsResponse is the response from a list request, it contains the paginated list of Domains.
 */
class ListDomainsResponse extends JsonSerializableType
{
    /**
     * @var array<DomainResponsePayload> $domains Domains is the list of domains in your account.
     */
    #[JsonProperty('domains'), ArrayType([DomainResponsePayload::class])]
    public array $domains;

    /**
     * @var int $from From is starting record count for current page.
     */
    #[JsonProperty('from')]
    public int $from;

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
     * @var int $to To is ending record count for current page.
     */
    #[JsonProperty('to')]
    public int $to;

    /**
     * @var int $totalCount TotalCount is total number of domains returned for request.
     */
    #[JsonProperty('totalCount')]
    public int $totalCount;

    /**
     * @param array{
     *   domains: array<DomainResponsePayload>,
     *   from: int,
     *   to: int,
     *   totalCount: int,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domains = $values['domains'];
        $this->from = $values['from'];
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
        $this->to = $values['to'];
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
