<?php

namespace Namecom\Domains\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class UpdateDomainRequestBodyAutorenewEnabled extends JsonSerializableType
{
    /**
     * @var bool $autorenewEnabled
     */
    #[JsonProperty('autorenewEnabled')]
    public bool $autorenewEnabled;

    /**
     * @param array{
     *   autorenewEnabled: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->autorenewEnabled = $values['autorenewEnabled'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
