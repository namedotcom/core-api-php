<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class DomainsPurchasePrivacyBody extends JsonSerializableType
{
    /**
     * @var ?string $idempotencyKey A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
     */
    public ?string $idempotencyKey;

    /**
     * @var ?float $purchasePrice PurchasePrice is the (prorated) amount you expect to pay.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?int $years Years is the number of years you wish to purchase Whois Privacy for. Years defaults to 1 and cannot be more then the domain expiration date.
     */
    #[JsonProperty('years')]
    public ?int $years;

    /**
     * @param array{
     *   idempotencyKey?: ?string,
     *   purchasePrice?: ?float,
     *   years?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->idempotencyKey = $values['idempotencyKey'] ?? null;
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->years = $values['years'] ?? null;
    }
}
