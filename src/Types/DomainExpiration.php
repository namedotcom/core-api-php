<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a domain in the subscribing account expires and the grace period starts. This event is informational; it is separate from lock, removal, and transfer-out events.
 */
class DomainExpiration extends JsonSerializableType
{
    /**
     * @var value-of<DomainExpirationEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The name of the expired domain.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var DateTime $expirationDate The date and time when the domain expired.
     */
    #[JsonProperty('expirationDate'), Date(Date::TYPE_DATETIME)]
    public DateTime $expirationDate;

    /**
     * @param array{
     *   eventName: value-of<DomainExpirationEventName>,
     *   domainName: string,
     *   expirationDate: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->expirationDate = $values['expirationDate'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
