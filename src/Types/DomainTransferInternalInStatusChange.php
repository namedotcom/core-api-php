<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a domain transfers IN to the webhook subscribers account from another name.com account.
 */
class DomainTransferInternalInStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainTransferInternalInStatusChangeEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var int $sourceAccountId The account id that previously owned the domain.
     */
    #[JsonProperty('sourceAccountId')]
    public int $sourceAccountId;

    /**
     * @var int $destinationAccountId The account id that now owns the domain.
     */
    #[JsonProperty('destinationAccountId')]
    public int $destinationAccountId;

    /**
     * @var value-of<DomainTransferInternalInStatusChangeStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var DateTime $occurredAt When the domain transfer in occurred.
     */
    #[JsonProperty('occurredAt'), Date(Date::TYPE_DATETIME)]
    public DateTime $occurredAt;

    /**
     * @var DomainResponsePayload $domain
     */
    #[JsonProperty('domain')]
    public DomainResponsePayload $domain;

    /**
     * @param array{
     *   eventName: value-of<DomainTransferInternalInStatusChangeEventName>,
     *   sourceAccountId: int,
     *   destinationAccountId: int,
     *   status: value-of<DomainTransferInternalInStatusChangeStatus>,
     *   occurredAt: DateTime,
     *   domain: DomainResponsePayload,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->sourceAccountId = $values['sourceAccountId'];
        $this->destinationAccountId = $values['destinationAccountId'];
        $this->status = $values['status'];
        $this->occurredAt = $values['occurredAt'];
        $this->domain = $values['domain'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
