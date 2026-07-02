<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * PricingResponse returns the Pricing related information from the GetPricingForDomain endpoint.
 * Covers standard and registry-premium **registration** pricing, plus renewal and transfer. Not a discovery endpoint — does not return `purchaseType`. Does not return aftermarket, expiring, or backorder acquisition prices. See the [Domain pricing guide](/guides/domain-pricing).
 */
class PricingResponse extends JsonSerializableType
{
    /**
     * @var bool $premium Premium indicates whether this registration pricing result is for a registry premium or other non-standard registration. Reflects registration pricing only — may differ from discovery `premium` for aftermarket, expiring, or backorder results. When `true`, `purchasePrice` must be passed on [Create Domain](/api/v1/reference/domains/create-domain), [Renew Domain](/api/v1/reference/domains/renew-domain), or [Create Transfer](/api/v1/reference/transfers/create-transfer), requests.
     */
    #[JsonProperty('premium')]
    public bool $premium;

    /**
     * @var ?float $purchasePrice PurchasePrice is the total standard or registry-premium registration cost for the requested `years` query parameter — not a one-year component. Does not include aftermarket, expiring, or backorder acquisition prices. If `null`, name.com is not currently accepting registrations for this domain/term combination. For registry premium create (`purchaseType: registration`), pass this value with the same `years`. For aftermarket, expiring, or backorder types, use `purchasePrice` from Search/Check Availability instead.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?float $renewalPrice RenewalPrice is the total renewal cost for the requested `years`. If `null`, name.com is not currently accepting renewals for this domain/term combination. Pass as `purchasePrice` on [Renew Domain](/api/v1/reference/domains/renew-domain) for premium renewals. Do not use for computing Create Domain `purchasePrice` or multi-year create totals.
     */
    #[JsonProperty('renewalPrice')]
    public ?float $renewalPrice;

    /**
     * @var ?float $transferPrice TransferPrice is the inbound transfer cost for this domain. The `years` query parameter does not affect this value. Pricing uses the TLD's minimum transfer/registration term (typically 1 year; for TLDs with a higher minimum, e.g. `.ai`, the total will reflect that minimum). If `null`, transfers are not accepted for this domain/term combination. Pass to [Create Transfer](/api/v1/reference/transfers/create-transfer) as `purchasePrice` when transfer price validation applies (required for premium transfers).
     */
    #[JsonProperty('transferPrice')]
    public ?float $transferPrice;

    /**
     * @param array{
     *   premium: bool,
     *   purchasePrice?: ?float,
     *   renewalPrice?: ?float,
     *   transferPrice?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->premium = $values['premium'];
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->renewalPrice = $values['renewalPrice'] ?? null;
        $this->transferPrice = $values['transferPrice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
