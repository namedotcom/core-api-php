<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class ListSubscribedWebhooksResponse extends JsonSerializableType
{
    /**
     * @var ?array<SubscriptionRecord> $subscriptions
     */
    #[JsonProperty('subscriptions'), ArrayType([SubscriptionRecord::class])]
    public ?array $subscriptions;

    /**
     * @param array{
     *   subscriptions?: ?array<SubscriptionRecord>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->subscriptions = $values['subscriptions'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
