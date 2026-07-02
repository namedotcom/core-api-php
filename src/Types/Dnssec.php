<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * DNSSEC contains all the data required to create a DS record at the registry.
 */
class Dnssec extends JsonSerializableType
{
    /**
     * @var int $algorithm
     */
    #[JsonProperty('algorithm')]
    public int $algorithm;

    /**
     * @var string $digest Digest is a digest of the DNSKEY RR that is registered with the registry.
     */
    #[JsonProperty('digest')]
    public string $digest;

    /**
     * @var int $digestType
     */
    #[JsonProperty('digestType')]
    public int $digestType;

    /**
     * @var string $domainName DomainName is the domain name.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var int $keyTag
     */
    #[JsonProperty('keyTag')]
    public int $keyTag;

    /**
     * @param array{
     *   algorithm: int,
     *   digest: string,
     *   digestType: int,
     *   domainName: string,
     *   keyTag: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->algorithm = $values['algorithm'];
        $this->digest = $values['digest'];
        $this->digestType = $values['digestType'];
        $this->domainName = $values['domainName'];
        $this->keyTag = $values['keyTag'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
