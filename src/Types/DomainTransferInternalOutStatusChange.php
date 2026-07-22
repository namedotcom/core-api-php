<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Payload sent when a domain transfers OUT from the webhook subscriber's account to another name.com account.
 */
class DomainTransferInternalOutStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainTransferInternalOutStatusChangeEventName> $eventName The name of the subscription event.
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var ?int $transferId The internal transfer ID for this move, when available. Omitted when no transfer ID has been assigned for the event.
     */
    #[JsonProperty('transferId')]
    public ?int $transferId;

    /**
     * @var int $sourceAccountId The account id that previously owned the domain (the losing account).
     */
    #[JsonProperty('sourceAccountId')]
    public int $sourceAccountId;

    /**
     * @var int $destinationAccountId The account id that now owns the domain (the gaining account).
     */
    #[JsonProperty('destinationAccountId')]
    public int $destinationAccountId;

    /**
     * @var value-of<DomainTransferInternalOutStatusChangeStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var DateTime $occurredAt When the domain transfer out occurred.
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
     *   eventName: value-of<DomainTransferInternalOutStatusChangeEventName>,
     *   sourceAccountId: int,
     *   destinationAccountId: int,
     *   status: value-of<DomainTransferInternalOutStatusChangeStatus>,
     *   occurredAt: DateTime,
     *   domain: DomainResponsePayload,
     *   transferId?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->transferId = $values['transferId'] ?? null;
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
