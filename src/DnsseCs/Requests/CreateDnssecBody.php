<?php

namespace Namecom\DnsseCs\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class CreateDnssecBody extends JsonSerializableType
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
     * @var int $keyTag
     */
    #[JsonProperty('keyTag')]
    public int $keyTag;

    /**
     * @param array{
     *   algorithm: int,
     *   digest: string,
     *   digestType: int,
     *   keyTag: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->algorithm = $values['algorithm'];
        $this->digest = $values['digest'];
        $this->digestType = $values['digestType'];
        $this->keyTag = $values['keyTag'];
    }
}
