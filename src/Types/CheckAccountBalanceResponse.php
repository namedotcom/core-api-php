<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class CheckAccountBalanceResponse extends JsonSerializableType
{
    /**
     * @var float $balance Balance is the current account balance in USD.
     */
    #[JsonProperty('balance')]
    public float $balance;

    /**
     * @param array{
     *   balance: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->balance = $values['balance'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
