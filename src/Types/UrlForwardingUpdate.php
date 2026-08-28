<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Fields for updating a URL forwarding entry. Omit a property to leave it unchanged. An empty `host` string is the apex, not "unchanged".
 */
class UrlForwardingUpdate extends JsonSerializableType
{
    /**
     * @var ?string $forwardsTo The destination URL to which this hostname will be forwarded.
     */
    #[JsonProperty('forwardsTo')]
    public ?string $forwardsTo;

    /**
     * @var ?string $host The subdomain portion of the hostname that is being forwarded. Omit this field to keep the existing host. Send an empty string to move the forwarding to the apex.
     */
    #[JsonProperty('host')]
    public ?string $host;

    /**
     * Meta tags to include in the HTML page when using "masked" forwarding.
     * Ignored for other forwarding types.
     * Example: `<meta name='keywords' content='fish, denver, platte'>`
     *
     * @var ?string $meta
     */
    #[JsonProperty('meta')]
    public ?string $meta;

    /**
     * The title to be used for the HTML page when using "masked" forwarding.
     * Ignored for other forwarding types.
     *
     * @var ?string $title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * The type of URL forwarding. Valid values:
     *   - `masked`: Retains the original domain in the address bar, preventing the user from seeing the actual destination URL. Sometimes called iframe forwarding.
     *   - `redirect`: Uses a standard HTTP redirect (301), which changes the address bar to the destination URL.
     *   - `302`: Uses a temporary HTTP redirect (302), which changes the address bar to the destination URL but indicates the resource is temporarily located elsewhere.
     *
     * @var ?value-of<UrlForwardingUpdateType> $type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @param array{
     *   forwardsTo?: ?string,
     *   host?: ?string,
     *   meta?: ?string,
     *   title?: ?string,
     *   type?: ?value-of<UrlForwardingUpdateType>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->forwardsTo = $values['forwardsTo'] ?? null;
        $this->host = $values['host'] ?? null;
        $this->meta = $values['meta'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->type = $values['type'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
