<?php

namespace Namecom\Domains\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class UpdateDomainRequestBodyLocked extends JsonSerializableType
{
    /**
     * @var bool $locked
     */
    #[JsonProperty('locked')]
    public bool $locked;

    /**
     * @param array{
     *   locked: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->locked = $values['locked'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
