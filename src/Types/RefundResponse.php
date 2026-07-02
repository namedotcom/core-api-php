<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * RefundResponse contains the results of a refund operation, including the individual order item results.
 * Refunds are issued to the original payment method on file. If the original payment method is unavailable, the refund will be credited to the account balance.
 */
class RefundResponse extends JsonSerializableType
{
    /**
     * @var array<RefundItemResult> $results An array of refund results for each order item that was processed.
     */
    #[JsonProperty('results'), ArrayType([RefundItemResult::class])]
    public array $results;

    /**
     * @var float $totalRefundAmount The total amount refunded across all order items in USD.
     */
    #[JsonProperty('totalRefundAmount')]
    public float $totalRefundAmount;

    /**
     * @param array{
     *   results: array<RefundItemResult>,
     *   totalRefundAmount: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->results = $values['results'];
        $this->totalRefundAmount = $values['totalRefundAmount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
