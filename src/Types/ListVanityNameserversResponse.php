<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListVanityNameserversResponse returns the list of vanity nameservers for the domain.
 */
class ListVanityNameserversResponse extends JsonSerializableType
{
    /**
     * @var ?int $lastPage LastPage is the identifier for the final page of results. It is only populated if there is another page of results after the current page. If no further pages exist, this field will be null.
     */
    #[JsonProperty('lastPage')]
    public ?int $lastPage;

    /**
     * @var ?int $nextPage NextPage is the identifier for the next page of results. It is only populated if there is another page of results after the current page. If no further pages exist, this field will be null.
     */
    #[JsonProperty('nextPage')]
    public ?int $nextPage;

    /**
     * @var array<VanityNameserverResponse> $vanityNameservers VanityNameservers is the list of vanity nameservers associated with the domain. If no vanity nameservers are configured, this will be an empty array.
     */
    #[JsonProperty('vanityNameservers'), ArrayType([VanityNameserverResponse::class])]
    public array $vanityNameservers;

    /**
     * @param array{
     *   vanityNameservers: array<VanityNameserverResponse>,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
        $this->vanityNameservers = $values['vanityNameservers'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
