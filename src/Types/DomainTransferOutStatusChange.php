<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Payload for `domain.transfer_out.status_change`. `completed` means the domain left name.com. `canceled` means the outbound transfer is no longer pending at the registry.
 */
class DomainTransferOutStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainTransferOutStatusChangeEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The domain whose outbound transfer status changed. For `completed`, the domain has left name.com; for `initiated` and `canceled`, it remains on the losing account.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<DomainTransferOutStatusChangeStatus> $status `initiated` (pending out started), `completed` (domain removed), or `canceled` (no longer pending at the registry).
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
