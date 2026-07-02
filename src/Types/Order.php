<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * Order contains all the data for an order.
 */
class Order extends JsonSerializableType
{
    /**
     * @var ?float $authAmount AuthAmount is the amount authorized to complete the order purchase.
     */
    #[JsonProperty('authAmount')]
    public ?float $authAmount;

    /**
     * @var ?string $createDate CreateDate is the date the order was placed.
     */
    #[JsonProperty('createDate')]
    public ?string $createDate;

    /**
     * @var ?string $currency Currency indicates currency of the order ('USD', 'CNY').
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?float $currencyRate CurrencyRate is the conversion rate from USD to order's currency.  This field is only populated if order's currency is non-USD.
     */
    #[JsonProperty('currencyRate')]
    public ?float $currencyRate;

    /**
     * @var ?float $finalAmount FinalAmount is the final amount of the order, after discounts and refunds.
     */
    #[JsonProperty('finalAmount')]
    public ?float $finalAmount;

    /**
     * @var ?int $id
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?array<OrderItem> $orderItems OrderItems is the collection of 1 or more items in the order.
     */
    #[JsonProperty('orderItems'), ArrayType([OrderItem::class])]
    public ?array $orderItems;

    /**
     * @var ?string $registrar Registrar is registrar with which order is placed.
     */
    #[JsonProperty('registrar')]
    public ?string $registrar;

    /**
     * @var ?string $status Status indicates the state of the order ('success', 'failed').
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?float $totalCapture TotalCapture is the amount captured.
     */
    #[JsonProperty('totalCapture')]
    public ?float $totalCapture;

    /**
     * @var ?float $totalRefund TotalRefund is the amount, if any, refunded. Default is 0.00.
     */
    #[JsonProperty('totalRefund')]
    public ?float $totalRefund;

    /**
     * @param array{
     *   authAmount?: ?float,
     *   createDate?: ?string,
     *   currency?: ?string,
     *   currencyRate?: ?float,
     *   finalAmount?: ?float,
     *   id?: ?int,
     *   orderItems?: ?array<OrderItem>,
     *   registrar?: ?string,
     *   status?: ?string,
     *   totalCapture?: ?float,
     *   totalRefund?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->authAmount = $values['authAmount'] ?? null;
        $this->createDate = $values['createDate'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->currencyRate = $values['currencyRate'] ?? null;
        $this->finalAmount = $values['finalAmount'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->orderItems = $values['orderItems'] ?? null;
        $this->registrar = $values['registrar'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->totalCapture = $values['totalCapture'] ?? null;
        $this->totalRefund = $values['totalRefund'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
