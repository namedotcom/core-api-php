<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * ListOrdersResponse is the response from a list request, it contains the paginated list of Orders.
 */
class ListOrdersResponse extends JsonSerializableType
{
    /**
     * @var ?int $lastPage LastPage is the identifier for the final page of results. It is only populated if there is another page of results after the current page.
     */
    #[JsonProperty('lastPage')]
    public ?int $lastPage;

    /**
     * @var ?int $nextPage NextPage is the identifier for the next page of results. It is only populated if there is another page of results after the current page.
     */
    #[JsonProperty('nextPage')]
    public ?int $nextPage;

    /**
     * @var int $totalCount TotalCount is total number of results.
     */
    #[JsonProperty('totalCount')]
    public int $totalCount;

    /**
     * @var int $from From specifies starting record number on current page.
     */
    #[JsonProperty('from')]
    public int $from;

    /**
     * @var int $to To specifies ending record number on current page.
     */
    #[JsonProperty('to')]
    public int $to;

    /**
     * @var array<Order> $orders Orders is the collection of orders, if any, in the requesting account.
     */
    #[JsonProperty('orders'), ArrayType([Order::class])]
    public array $orders;

    /**
     * @var ?int $parentAccountId ParentAccountId field is populated when requesting account has a parent account id.
     */
    #[JsonProperty('parentAccountId')]
    public ?int $parentAccountId;

    /**
     * @param array{
     *   totalCount: int,
     *   from: int,
     *   to: int,
     *   orders: array<Order>,
     *   lastPage?: ?int,
     *   nextPage?: ?int,
     *   parentAccountId?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->lastPage = $values['lastPage'] ?? null;
        $this->nextPage = $values['nextPage'] ?? null;
        $this->totalCount = $values['totalCount'];
        $this->from = $values['from'];
        $this->to = $values['to'];
        $this->orders = $values['orders'];
        $this->parentAccountId = $values['parentAccountId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
