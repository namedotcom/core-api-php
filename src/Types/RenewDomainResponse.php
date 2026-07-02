<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * RenewDomainResponse contains the updated domain info as well as the order info for the renewed domain.
 */
class RenewDomainResponse extends JsonSerializableType
{
    /**
     * @var ?Domain $domain
     */
    #[JsonProperty('domain')]
    public ?Domain $domain;

    /**
     * @var ?int $order
     */
    #[JsonProperty('order')]
    public ?int $order;

    /**
     * @var ?float $totalPaid TotalPaid is the total amount paid, including VAT.
     */
    #[JsonProperty('totalPaid')]
    public ?float $totalPaid;

    /**
     * @param array{
     *   domain?: ?Domain,
     *   order?: ?int,
     *   totalPaid?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->domain = $values['domain'] ?? null;
        $this->order = $values['order'] ?? null;
        $this->totalPaid = $values['totalPaid'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
