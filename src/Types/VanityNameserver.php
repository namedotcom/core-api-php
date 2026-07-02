<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * VanityNameserver represents a custom nameserver associated with a domain, including its hostname and a list of IP addresses for glue records.
 */
class VanityNameserver extends JsonSerializableType
{
    /**
     * @var string $domainName DomainName is the root domain for which this vanity nameserver is created. For example, if the hostname is 'ns1.example.com', the domainName would be 'example.com'.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var string $hostname Hostname is the fully qualified domain name (FQDN) of the vanity nameserver. It must be a subdomain of the domain specified in 'domainName'.
     */
    #[JsonProperty('hostname')]
    public string $hostname;

    /**
     * @var array<string> $ips IPs is a list of IP addresses that are used for glue records for this vanity nameserver. These should be valid IPv4 or IPv6 addresses.
     */
    #[JsonProperty('ips'), ArrayType(['string'])]
    public array $ips;

    /**
     * @param array{
     *   domainName: string,
     *   hostname: string,
     *   ips: array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->hostname = $values['hostname'];
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
