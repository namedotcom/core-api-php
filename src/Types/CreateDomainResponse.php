<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * CreateDomainResponse contains the domain info as well as the order info for the created domain.
 */
class CreateDomainResponse extends JsonSerializableType
{
    /**
     * @var DomainResponsePayload $domain
     */
    #[JsonProperty('domain')]
    public DomainResponsePayload $domain;

    /**
     * @var int $order Order is an identifier for this purchase.
     */
    #[JsonProperty('order')]
    public int $order;

    /**
     * @var float $totalPaid TotalPaid is the total amount paid, including VAT and Whois privacy protection.
     */
    #[JsonProperty('totalPaid')]
    public float $totalPaid;

    /**
     * @param array{
     *   domain: DomainResponsePayload,
     *   order: int,
     *   totalPaid: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domain = $values['domain'];
        $this->order = $values['order'];
        $this->totalPaid = $values['totalPaid'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
