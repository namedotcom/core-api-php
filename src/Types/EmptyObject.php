<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;

/**
 * Empty JSON object. This operation does not accept a payload; clients must still send `Content-Type: application/json` with body `{}`.
 */
class EmptyObject extends JsonSerializableType
{
    /**
     * @param array{
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        unset($values);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
