<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * RefundItemResult contains the result of a refund operation for a single order item.
 */
class RefundItemResult extends JsonSerializableType
{
    /**
     * @var int $orderId The unique identifier of the Order that was processed.
     */
    #[JsonProperty('orderId')]
    public int $orderId;

    /**
     * @var int $orderItemId The unique identifier of the Order Item that was processed.
     */
    #[JsonProperty('orderItemId')]
    public int $orderItemId;

    /**
     * @var value-of<RefundItemResultOrderItemStatus> $orderItemStatus The status of the refund operation for this item.
     */
    #[JsonProperty('orderItemStatus')]
    public string $orderItemStatus;

    /**
     * @var float $refundAmount The amount refunded for this order item in USD.
     */
    #[JsonProperty('refundAmount')]
    public float $refundAmount;

    /**
     * @var ?string $message Additional information about the refund result, especially useful for failed items.
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @param array{
     *   orderId: int,
     *   orderItemId: int,
     *   orderItemStatus: value-of<RefundItemResultOrderItemStatus>,
     *   refundAmount: float,
     *   message?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'];
        $this->orderItemId = $values['orderItemId'];
        $this->orderItemStatus = $values['orderItemStatus'];
        $this->refundAmount = $values['refundAmount'];
        $this->message = $values['message'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
