<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * VanityNameserver response schema with full hostname
 */
class VanityNameserverResponse extends JsonSerializableType
{
    /**
     * @var ?string $hostname Hostname is the fully qualified domain name (FQDN) of the vanity nameserver. It must be a subdomain of the domain specified in 'domainName'.
     */
    #[JsonProperty('hostname')]
    public ?string $hostname;

    /**
     * @var string $domainName DomainName is the root domain for which this vanity nameserver is created. For example, if the hostname is 'ns1.example.com', the domainName would be 'example.com'.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var array<string> $ips IPs is a list of IP addresses that are used for glue records for this vanity nameserver. These should be valid IPv4 or IPv6 addresses.
     */
    #[JsonProperty('ips'), ArrayType(['string'])]
    public array $ips;

    /**
     * @param array{
     *   domainName: string,
     *   ips: array<string>,
     *   hostname?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->hostname = $values['hostname'] ?? null;
        $this->domainName = $values['domainName'];
        $this->ips = $values['ips'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
