<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * URLForwarding represents a URL forwarding entry response, allowing a domain to redirect to another URL using different forwarding methods.
 */
class UrlForwardingResponse extends JsonSerializableType
{
    /**
     * @var ?int $id Server-assigned unique identifier for the URL forwarding record. Use this ID with the URL Forwarding by-ID endpoints to get, update, or delete records.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $host The subdomain portion of the hostname that is being forwarded.
     */
    #[JsonProperty('host')]
    public ?string $host;

    /**
     * @var ?string $domainName The domain name (without subdomains) that is being forwarded.
     */
    #[JsonProperty('domainName')]
    public ?string $domainName;

    /**
     * @var string $forwardsTo The destination URL to which this hostname will be forwarded.
     */
    #[JsonProperty('forwardsTo')]
    public string $forwardsTo;

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
     * @var value-of<UrlForwardingType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @param array{
     *   forwardsTo: string,
     *   type: value-of<UrlForwardingType>,
     *   id?: ?int,
     *   host?: ?string,
     *   domainName?: ?string,
     *   meta?: ?string,
     *   title?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->host = $values['host'] ?? null;
        $this->domainName = $values['domainName'] ?? null;
        $this->forwardsTo = $values['forwardsTo'];
        $this->meta = $values['meta'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->type = $values['type'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
