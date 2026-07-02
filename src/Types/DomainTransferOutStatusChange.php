<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Payload sent when a domain transfer OUT from name.com to another registrar has a status change (initiated, completed, or canceled). When status is "completed", the domain has been removed from name.com. In some edge cases (including near-expiration scenarios) the data may not be fully accurate.
 */
class DomainTransferOutStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainTransferOutStatusChangeEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The domain that has transferred out of name.com.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<DomainTransferOutStatusChangeStatus> $status The status of the transfer out event. May be "initiated" (transfer out was started), "completed" (domain has been removed from the account), or "canceled" (transfer out was canceled before completion).
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?string $registryClientId The registry client ID associated with the domain at the time of transfer out, when available. This can help identify the gaining registrar at the registry.
     */
    #[JsonProperty('registryClientId')]
    public ?string $registryClientId;

    /**
     * @param array{
     *   eventName: value-of<DomainTransferOutStatusChangeEventName>,
     *   domainName: string,
     *   status: value-of<DomainTransferOutStatusChangeStatus>,
     *   registryClientId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->status = $values['status'];
        $this->registryClientId = $values['registryClientId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
