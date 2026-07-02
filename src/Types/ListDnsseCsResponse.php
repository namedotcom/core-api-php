<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListDNSSECsResponse contains the list of DS records at the registry.
 */
class ListDnsseCsResponse extends JsonSerializableType
{
    /**
     * @var array<Dnssec> $dnssec Dnssec is the list of registered DNSSEC keys.
     */
    #[JsonProperty('dnssec'), ArrayType([Dnssec::class])]
    public array $dnssec;

    /**
     * @param array{
     *   dnssec: array<Dnssec>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->dnssec = $values['dnssec'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
