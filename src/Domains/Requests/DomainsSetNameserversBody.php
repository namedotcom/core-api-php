<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class DomainsSetNameserversBody extends JsonSerializableType
{
    /**
     * @var array<string> $nameservers Nameservers is a list of the nameservers to set. Nameservers should already be set up and hosting the zone properly as some registries will verify before allowing the change.
     */
    #[JsonProperty('nameservers'), ArrayType(['string'])]
    public array $nameservers;

    /**
     * @param array{
     *   nameservers: array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->nameservers = $values['nameservers'];
    }
}
