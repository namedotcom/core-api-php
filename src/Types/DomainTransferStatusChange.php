<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Payload sent when a domain transfer IN to name.com is processing. This schema represents transfer-in events where name.com is the gaining registrar.
 */
class DomainTransferStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainTransferStatusChangeEventName> $eventName The name of the subscription event
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName The domain that the transfer status has changed for
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<TransferStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   eventName: value-of<DomainTransferStatusChangeEventName>,
     *   domainName: string,
     *   status: value-of<TransferStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->status = $values['status'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
