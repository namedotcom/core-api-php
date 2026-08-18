<?php

namespace Namecom\Refunds\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class RefundRequest extends JsonSerializableType
{
    /**
     * @var int $orderId The unique identifier of the order containing the item(s) to be refunded. Use the List Orders endpoint to retrieve order IDs.
     */
    #[JsonProperty('orderId')]
    public int $orderId;

    /**
     * @var array<int> $orderItemIds An array of order item IDs to be refunded. All items must belong to the specified order. Use the List Orders endpoint to retrieve order item IDs.
     */
    #[JsonProperty('orderItemIds'), ArrayType(['integer'])]
    public array $orderItemIds;

    /**
     * @param array{
     *   orderId: int,
     *   orderItemIds: array<int>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->orderId = $values['orderId'];
        $this->orderItemIds = $values['orderItemIds'];
    }
}
