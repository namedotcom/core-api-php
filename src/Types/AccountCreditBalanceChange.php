<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class AccountCreditBalanceChange extends JsonSerializableType
{
    /**
     * @var ?value-of<AccountCreditBalanceChangeEventName> $eventName The name of the subscription event
     */
    #[JsonProperty('eventName')]
    public ?string $eventName;

    /**
     * @var ?int $accountId The account ID the subscription is for
     */
    #[JsonProperty('accountId')]
    public ?int $accountId;

    /**
     * @var ?float $balance The remaining balance of account credit
     */
    #[JsonProperty('balance')]
    public ?float $balance;

    /**
     * @param array{
     *   eventName?: ?value-of<AccountCreditBalanceChangeEventName>,
     *   accountId?: ?int,
     *   balance?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->eventName = $values['eventName'] ?? null;
        $this->accountId = $values['accountId'] ?? null;
        $this->balance = $values['balance'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
