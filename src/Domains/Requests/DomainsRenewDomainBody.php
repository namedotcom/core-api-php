<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class DomainsRenewDomainBody extends JsonSerializableType
{
    /**
     * @var ?float $purchasePrice PurchasePrice is the total USD renewal cost for the requested `years`, before VAT. VAT is applied when applicable and must not be included here. If sent, must match Get Pricing `renewalPrice` exactly. **Omit** for standard (non-premium) renewals. **Required** for premium renewals — use `renewalPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years`.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?int $years Years specifies the renewal term in years. Defaults to each TLD's minimum registration term if omitted — usually 1 year (2 for `.ai`). Must be a supported registration term for the TLD (commonly 1–10 years). For premium renewals, call [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with the same `years` value.
     */
    #[JsonProperty('years')]
    public ?int $years;

    /**
     * @param array{
     *   purchasePrice?: ?float,
     *   years?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->years = $values['years'] ?? null;
    }
}
