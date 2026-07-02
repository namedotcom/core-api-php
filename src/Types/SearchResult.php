<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * SearchResult is returned by the CheckAvailability and Search endpoints.
 */
class SearchResult extends JsonSerializableType
{
    /**
     * @var string $domainName DomainName is the punycode encoding of the result domain name.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var ?bool $premium Premium indicates whether this discovery result has premium or non-standard pricing. Only returned for purchasable domains. When `true` with `purchaseType: registration` → registry premium (use [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) for multi-year totals). When `true` with aftermarket, expiring, or backorder `purchaseType` values → flat acquisition fee (use discovery `purchasePrice`; `years` on create does not multiply price or guarantee registration length). When `true`, `purchasePrice` must be passed on Create Domain.
     */
    #[JsonProperty('premium')]
    public ?bool $premium;

    /**
     * @var bool $purchasable Purchasable indicates whether the search result is available for purchase.
     */
    #[JsonProperty('purchasable')]
    public bool $purchasable;

    /**
     * @var ?float $purchasePrice PurchasePrice is the minimum-term list or flat acquisition price from discovery, in USD. Only returned for purchasable domains. For `purchaseType: registration` when `purchasePrice` is required on create, use [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years` instead. For aftermarket, expiring, and backorder types, pass this flat acquisition fee on Create Domain — not affected by `years`. Get Pricing does not return these acquisition prices. Recommended to re-check with Check Availability immediately before create for all types — prices can change.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?value-of<SearchPurchaseType> $purchaseType PurchaseType indicates what kind of purchase this discovery result is for. Only returned for purchasable domains. Pass to Create Domain as `purchaseType`. See [SearchPurchaseType](#/components/schemas/SearchPurchaseType) for pricing behavior per value. When `premium: true` or the type is not `registration`, follow the [Domain pricing guide](/guides/domain-pricing).
     */
    #[JsonProperty('purchaseType')]
    public ?string $purchaseType;

    /**
     * @var ?float $renewalPrice RenewalPrice is the minimum-term renewal total for this domain (typically 1 year; varies by TLD). Only returned for purchasable domains. Informational for standard [Renew Domain](/api/v1/reference/domains/renew-domain) flows — do **not** use to calculate Create Domain `purchasePrice` or multi-year create totals. For premium renewals, use `renewalPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years`, not this discovery value.
     */
    #[JsonProperty('renewalPrice')]
    public ?float $renewalPrice;

    /**
     * @var string $sld SLD is first portion of the domain_name.
     */
    #[JsonProperty('sld')]
    public string $sld;

    /**
     * @var string $tld TLD is the rest of the domain_name after the SLD.
     */
    #[JsonProperty('tld')]
    public string $tld;

    /**
     * @var ?string $reason Reason provides additional context when unavailable (e.g. registry is in maintenance).
     */
    #[JsonProperty('reason')]
    public ?string $reason;

    /**
     * @param array{
     *   domainName: string,
     *   purchasable: bool,
     *   sld: string,
     *   tld: string,
     *   premium?: ?bool,
     *   purchasePrice?: ?float,
     *   purchaseType?: ?value-of<SearchPurchaseType>,
     *   renewalPrice?: ?float,
     *   reason?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->premium = $values['premium'] ?? null;
        $this->purchasable = $values['purchasable'];
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->purchaseType = $values['purchaseType'] ?? null;
        $this->renewalPrice = $values['renewalPrice'] ?? null;
        $this->sld = $values['sld'];
        $this->tld = $values['tld'];
        $this->reason = $values['reason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
