<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListURLForwardingsResponse is the response for the ListURLForwardings function.
 */
class ListUrlForwardingsResponse extends JsonSerializableType
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
     * @var array<UrlForwardingResponse> $urlForwarding URLForwarding is the list of URL forwarding entries.
     */
    #[JsonProperty('urlForwarding'), ArrayType([UrlForwardingResponse::class])]
    public array $urlForwarding;

    /**
     * @param array{
     *   urlForwarding: array<UrlForwardingResponse>,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
        $this->urlForwarding = $values['urlForwarding'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
