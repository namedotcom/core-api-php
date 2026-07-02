<?php

namespace Namecom\DnsseCs\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class CreateDnssecBody extends JsonSerializableType
{
    /**
     * @var ?int $algorithm
     */
    #[JsonProperty('algorithm')]
    public ?int $algorithm;

    /**
     * @var ?string $digest Digest is a digest of the DNSKEY RR that is registered with the registry.
     */
    #[JsonProperty('digest')]
    public ?string $digest;

    /**
     * @var ?string $createDnssecBodyDomainName The name of the domain.
     */
    #[JsonProperty('domainName')]
    public ?string $createDnssecBodyDomainName;

    /**
     * @var ?int $digestType
     */
    #[JsonProperty('digestType')]
    public ?int $digestType;

    /**
     * @var ?int $keyTag
     */
    #[JsonProperty('keyTag')]
    public ?int $keyTag;

    /**
     * @param array{
     *   algorithm?: ?int,
     *   digest?: ?string,
     *   createDnssecBodyDomainName?: ?string,
     *   digestType?: ?int,
     *   keyTag?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->algorithm = $values['algorithm'] ?? null;
        $this->digest = $values['digest'] ?? null;
        $this->createDnssecBodyDomainName = $values['createDnssecBodyDomainName'] ?? null;
        $this->digestType = $values['digestType'] ?? null;
        $this->keyTag = $values['keyTag'] ?? null;
    }
}
