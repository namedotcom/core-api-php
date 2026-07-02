<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * CreateTransferResponse returns the newly created transfer resource as well as the order information.
 */
class CreateTransferResponse extends JsonSerializableType
{
    /**
     * @var int $order Order is an identifier for this purchase.
     */
    #[JsonProperty('order')]
    public int $order;

    /**
     * @var float $totalPaid TotalPaid is the total amount paid, including VAT and Whois Privacy.
     */
    #[JsonProperty('totalPaid')]
    public float $totalPaid;

    /**
     * @var Transfer $transfer
     */
    #[JsonProperty('transfer')]
    public Transfer $transfer;

    /**
     * @var ?CreateTransferResponseWarnings $warnings Optional transfer warnings surfaced by the API when non-blocking registry statuses are detected.
     */
    #[JsonProperty('warnings')]
    public ?CreateTransferResponseWarnings $warnings;

    /**
     * @param array{
     *   order: int,
     *   totalPaid: float,
     *   transfer: Transfer,
     *   warnings?: ?CreateTransferResponseWarnings,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->order = $values['order'];
        $this->totalPaid = $values['totalPaid'];
        $this->transfer = $values['transfer'];
        $this->warnings = $values['warnings'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
