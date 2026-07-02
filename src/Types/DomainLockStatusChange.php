<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class DomainLockStatusChange extends JsonSerializableType
{
    /**
     * @var value-of<DomainLockStatusChangeEventName> $eventName
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $domainName Fully-qualified domain name
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<DomainLockStatusChangeAction> $action
     */
    #[JsonProperty('action')]
    public string $action;

    /**
     * @var value-of<DomainLockStatusChangeLockType> $lockType The lock type affected by this event (added or removed)
     */
    #[JsonProperty('lockType')]
    public string $lockType;

    /**
     * @var array<string> $registryStatuses Current registry statuses after the change
     */
    #[JsonProperty('registryStatuses'), ArrayType(['string'])]
    public array $registryStatuses;

    /**
     * @param array{
     *   eventName: value-of<DomainLockStatusChangeEventName>,
     *   domainName: string,
     *   action: value-of<DomainLockStatusChangeAction>,
     *   lockType: value-of<DomainLockStatusChangeLockType>,
     *   registryStatuses: array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->domainName = $values['domainName'];
        $this->action = $values['action'];
        $this->lockType = $values['lockType'];
        $this->registryStatuses = $values['registryStatuses'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
