<?php

namespace Namecom\VanityNameservers\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class CreateVanityNameserverBody extends JsonSerializableType
{
    /**
     * @var string $hostname The subdomain portion of the nameserver hostname. The domain portion will be  taken from the URL path. For example, to create 'ns1.example.com', specify 'ns1'  when calling the endpoint for the domain 'example.com'.
     */
    #[JsonProperty('hostname')]
    public string $hostname;

    /**
     * @var array<string> $ips IPs is a list of IP addresses that are used for glue records for this nameserver. These should be valid IPv4 or IPv6 addresses.
     */
    #[JsonProperty('ips'), ArrayType(['string'])]
    public array $ips;

    /**
     * @param array{
     *   hostname: string,
     *   ips: array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->hostname = $values['hostname'];
        $this->ips = $values['ips'];
    }
}
