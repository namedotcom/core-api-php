<?php

namespace Namecom\WebhookNotifications\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class ModifySubscriptionRequest extends JsonSerializableType
{
    /**
     * @var ?string $url Optionally update the URL we send the webhook data to
     */
    #[JsonProperty('url')]
    public ?string $url;

    /**
     * @var ?bool $active Optionally update if the subscription is currently active
     */
    #[JsonProperty('active')]
    public ?bool $active;

    /**
     * @param array{
     *   url?: ?string,
     *   active?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->url = $values['url'] ?? null;
        $this->active = $values['active'] ?? null;
    }
}
