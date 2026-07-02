<?php

namespace Namecom\WebhookNotifications\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\AvailableWebhooks;
use Namecom\Core\Json\JsonProperty;

class SubscribeToNotification extends JsonSerializableType
{
    /**
     * @var value-of<AvailableWebhooks> $eventName
     */
    #[JsonProperty('eventName')]
    public string $eventName;

    /**
     * @var string $url The URL we will send the notification data to
     */
    #[JsonProperty('url')]
    public string $url;

    /**
     * @var bool $active If the webhook should be active. This allows a webhook to be deactivated in our system. It may be useful to deactivate a webhook if the server that receives the POST request is undergoing scheduled maintenance, for example.
     */
    #[JsonProperty('active')]
    public bool $active;

    /**
     * @param array{
     *   eventName: value-of<AvailableWebhooks>,
     *   url: string,
     *   active: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eventName = $values['eventName'];
        $this->url = $values['url'];
        $this->active = $values['active'];
    }
}
