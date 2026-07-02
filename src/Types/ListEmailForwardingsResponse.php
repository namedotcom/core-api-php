<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListEmailForwardingsResponse returns the list of email forwarding entries as well as the pagination information.
 */
class ListEmailForwardingsResponse extends JsonSerializableType
{
    /**
     * @var array<EmailForwarding> $emailForwarding EmailForwarding is the list of forwarded email boxes.
     */
    #[JsonProperty('emailForwarding'), ArrayType([EmailForwarding::class])]
    public array $emailForwarding;

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
     * @param array{
     *   emailForwarding: array<EmailForwarding>,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->emailForwarding = $values['emailForwarding'];
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
