<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * OrderItem contains all the order item data.
 */
class OrderItem extends JsonSerializableType
{
    /**
     * @var int $duration Duration is the number of intervals.
     */
    #[JsonProperty('duration')]
    public int $duration;

    /**
     * @var int $id
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var ?string $interval Interval is the  unit of time ("year", "month"). May be null for items that have no applicable interval.
     */
    #[JsonProperty('interval')]
    public ?string $interval;

    /**
     * @var ?string $name Name is name of the item ('example.ninja').
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?float $originalPrice OriginalPrice is the original price of the item before discounts.
     */
    #[JsonProperty('originalPrice')]
    public ?float $originalPrice;

    /**
     * @var float $price Price is the final price of the item.
     */
    #[JsonProperty('price')]
    public float $price;

    /**
     * @var ?float $priceNonUsd PriceNonUsd is the price of the item if order has non-usd currency.
     */
    #[JsonProperty('priceNonUsd')]
    public ?float $priceNonUsd;

    /**
     * @var int $quantity Quantity is the number of items.
     */
    #[JsonProperty('quantity')]
    public int $quantity;

    /**
     * @var string $status Status indicates state of the order ('success', 'failed', 'refunded').
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?float $taxAmount TaxAmount is the tax charged for this item, if applicable.
     */
    #[JsonProperty('taxAmount')]
    public ?float $taxAmount;

    /**
     * @var ?string $tld Tld is (optional) tld of domain name, if applicable ('ninja').
     */
    #[JsonProperty('tld')]
    public ?string $tld;

    /**
     * @var string $type Type is type of  the item ('registration', 'whois_privacy').
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var bool $isRefundable IsRefundable indicates whether the item in your order is currently eligible for a refund through the refund endpoint based on name.com's refund rules. These refunds are only applicable for invalid or fraudulent orders within a few days or registration (usually 5).
     */
    #[JsonProperty('isRefundable')]
    public bool $isRefundable;

    /**
     * @param array{
     *   duration: int,
     *   id: int,
     *   price: float,
     *   quantity: int,
     *   status: string,
     *   type: string,
     *   isRefundable: bool,
     *   interval?: ?string,
     *   name?: ?string,
     *   originalPrice?: ?float,
     *   priceNonUsd?: ?float,
     *   taxAmount?: ?float,
     *   tld?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->duration = $values['duration'];
        $this->id = $values['id'];
        $this->interval = $values['interval'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->originalPrice = $values['originalPrice'] ?? null;
        $this->price = $values['price'];
        $this->priceNonUsd = $values['priceNonUsd'] ?? null;
        $this->quantity = $values['quantity'];
        $this->status = $values['status'];
        $this->taxAmount = $values['taxAmount'] ?? null;
        $this->tld = $values['tld'] ?? null;
        $this->type = $values['type'];
        $this->isRefundable = $values['isRefundable'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
