<?php

namespace Namecom\WebhookNotifications\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class ModifySubscriptionRequestBodyActive extends JsonSerializableType
{
    /**
     * @var bool $active
     */
    #[JsonProperty('active')]
    public bool $active;

    /**
     * @param array{
     *   active: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->active = $values['active'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
