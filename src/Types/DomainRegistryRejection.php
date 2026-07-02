<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a domain create request fails after asynchronous registry processing. Most domain creates succeed immediately; this event covers the case where the registry initially accepts processing but later rejects or fails the registration.
 */
class DomainRegistryRejection extends JsonSerializableType
{
    /**
     * @var value-of<DomainRegistryRejectionEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The domain name that failed to register.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var int $orderId The unique identifier of the order for the failed domain create. Use the List Orders endpoint to retrieve order details.
     */
    #[JsonProperty('orderId')]
    public int $orderId;

    /**
     * @var int $orderItemId The unique identifier of the order line item for the failed domain create. Use the List Orders endpoint to retrieve order item details.
     */
    #[JsonProperty('orderItemId')]
    public int $orderItemId;

    /**
     * @var DateTime $occurredAt When the asynchronous registration failure was recorded.
     */
    #[JsonProperty('occurredAt'), Date(Date::TYPE_DATETIME)]
    public DateTime $occurredAt;

    /**
     * @var ?string $reason Optional human-readable or registry-provided detail about the failure, when available.
     */
    #[JsonProperty('reason')]
    public ?string $reason;

    /**
     * @param array{
     *   eventName: value-of<DomainRegistryRejectionEventName>,
     *   domainName: string,
     *   orderId: int,
     *   orderItemId: int,
     *   occurredAt: DateTime,
     *   reason?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->orderId = $values['orderId'];
        $this->orderItemId = $values['orderItemId'];
        $this->occurredAt = $values['occurredAt'];
        $this->reason = $values['reason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
