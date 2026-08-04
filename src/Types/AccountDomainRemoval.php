<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a domain is removed from the subscribing account.
 */
class AccountDomainRemoval extends JsonSerializableType
{
    /**
     * @var value-of<AccountDomainRemovalEventName> $eventName The name of the subscription event
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The name of the domain that was removed
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<AccountDomainRemovalReason> $reason Why the domain left inventory: `expiration` (registry delete / post-expiry inventory loss), `agp_refund` (AGP refund delete), or `administrative` (ops/support removal).
     */
    #[JsonProperty('reason')]
    public string $reason;

    /**
     * @var DateTime $expireDate The date and time when the domain expired
     */
    #[JsonProperty('expireDate'), Date(Date::TYPE_DATETIME)]
    public DateTime $expireDate;

    /**
     * @param array{
     *   eventName: value-of<AccountDomainRemovalEventName>,
     *   domainName: string,
     *   reason: value-of<AccountDomainRemovalReason>,
     *   expireDate: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->reason = $values['reason'];
        $this->expireDate = $values['expireDate'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
