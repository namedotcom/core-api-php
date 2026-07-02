<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class ModifySubscriptionResponse extends JsonSerializableType
{
    /**
     * @var ?SubscriptionRecord $subscription
     */
    #[JsonProperty('subscription')]
    public ?SubscriptionRecord $subscription;

    /**
     * @param array{
     *   subscription?: ?SubscriptionRecord,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->subscription = $values['subscription'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
