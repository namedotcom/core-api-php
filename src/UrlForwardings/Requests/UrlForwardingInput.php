<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\UrlForwardings\Types\UrlForwardingInputType;

class UrlForwardingInput extends JsonSerializableType
{
    /**
     * @var string $forwardsTo The destination URL to which this hostname will be forwarded.
     */
    #[JsonProperty('forwardsTo')]
    public string $forwardsTo;

    /**
     * @var string $host The subdomain portion of the hostname that is being forwarded. Use an empty string for the apex.
     */
    #[JsonProperty('host')]
    public string $host;

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
     * @var value-of<UrlForwardingInputType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @param array{
     *   forwardsTo: string,
     *   host: string,
     *   type: value-of<UrlForwardingInputType>,
     *   meta?: ?string,
     *   title?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->forwardsTo = $values['forwardsTo'];
        $this->host = $values['host'];
        $this->meta = $values['meta'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->type = $values['type'];
    }
}
