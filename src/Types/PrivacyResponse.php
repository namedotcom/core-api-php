<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * PrivacyResponse contains the updated domain info as well as the order info for the Whois Privacy that was enabled or extended.
 */
class PrivacyResponse extends JsonSerializableType
{
    /**
     * @var ?DomainResponsePayload $domain
     */
    #[JsonProperty('domain')]
    public ?DomainResponsePayload $domain;

    /**
     * @var int $order Order is an identifier for this purchase.
     */
    #[JsonProperty('order')]
    public int $order;

    /**
     * @var float $totalPaid TotalPaid is the total amount paid, including VAT when applicable. Whois Privacy is free and is not included in this amount.
     */
    #[JsonProperty('totalPaid')]
    public float $totalPaid;

    /**
     * @param array{
     *   order: int,
     *   totalPaid: float,
     *   domain?: ?DomainResponsePayload,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domain = $values['domain'] ?? null;
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
