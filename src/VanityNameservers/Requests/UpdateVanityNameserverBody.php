<?php

namespace Namecom\VanityNameservers\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class UpdateVanityNameserverBody extends JsonSerializableType
{
    /**
     * @var ?array<string> $ips IPs is the updated list of IP addresses to be used for glue records for this vanity nameserver. Providing an empty array will remove all existing IPs.
     */
    #[JsonProperty('ips'), ArrayType(['string'])]
    public ?array $ips;

    /**
     * @param array{
     *   ips?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ips = $values['ips'] ?? null;
    }
}
