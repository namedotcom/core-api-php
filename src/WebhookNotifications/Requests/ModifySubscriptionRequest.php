<?php

namespace Namecom\WebhookNotifications\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\WebhookNotifications\Types\ModifySubscriptionRequestBodyUrl;
use Namecom\WebhookNotifications\Types\ModifySubscriptionRequestBodyActive;

class ModifySubscriptionRequest extends JsonSerializableType
{
    /**
     * @var (
     *    ModifySubscriptionRequestBodyUrl
     *   |ModifySubscriptionRequestBodyActive
     * ) $body
     */
    public ModifySubscriptionRequestBodyUrl|ModifySubscriptionRequestBodyActive $body;

    /**
     * @param array{
     *   body: (
     *    ModifySubscriptionRequestBodyUrl
     *   |ModifySubscriptionRequestBodyActive
     * ),
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
