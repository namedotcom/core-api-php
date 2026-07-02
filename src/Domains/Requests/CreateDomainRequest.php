<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\DomainCreatePayload;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;
use Namecom\Types\DomainClaimsInfo;

class CreateDomainRequest extends JsonSerializableType
{
    /**
     * @var ?string $idempotencyKey A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
     */
    public ?string $idempotencyKey;

    /**
     * @var DomainCreatePayload $domain
     */
    #[JsonProperty('domain')]
    public DomainCreatePayload $domain;

    /**
     * @var ?float $purchasePrice PurchasePrice is the price in USD for purchasing this domain for the minimum time period (typically 1 year). PurchasePrice is required if purchaseType is not "registration" or if it is a premium domain. If privacyEnabled is set, the regular price for Whois Privacy protection will be added automatically. If VAT tax applies, it will also be added automatically.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?string $purchaseType PurchaseType indicates what kind of purchase this domain create is for. Defaults to `registration` if omitted. **Recommended:** Use `registration` unless you support acquisition types (aftermarket, expiring, backorder) — see the [Domain purchase pricing guide](/guides/domain-pricing). This value should be copied from the [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability) result. The value `registration` covers both standard and **registry premium** domains — use the `premium` flag from the discovery result to tell them apart. Aftermarket, expiring, and backorder types use flat acquisition fees from Search or Check Availability; see the [Domain pricing guide](/guides/domain-pricing).
     */
    #[JsonProperty('purchaseType')]
    public ?string $purchaseType;

    /**
     * TLDRequirements is a way to pass additional data that is required by some registries. You can check before registration by using the [Domain Info](/api/v1/reference/domain-info/get-specific-tld-requirements) API.
     * As these requirements vary wildly between registries and TLDs, we are not attempting to document them here.
     * #### IDN Domains
     * This parameter is required for registering domains that contain non-ASCII characters.  The value should be the specific code for the character set, such as `ES` for Spanish, or `CYRL` for Cyrillic. These abbreviations can vary between TLDs, and it is highly recommended that you use [Domain Info](/api/v1/reference/domain-info/get-specific-tld-requirements) API to ensure that the TLD allows for the specific IDN table, as well as the correct abbreviation.
     *
     * @var ?array<string, string> $tldRequirements
     */
    #[JsonProperty('tldRequirements'), ArrayType(['string' => 'string'])]
    public ?array $tldRequirements;

    /**
     * @var ?DomainClaimsInfo $claims
     */
    #[JsonProperty('claims')]
    public ?DomainClaimsInfo $claims;

    /**
     * @var ?int $years Years specifies the registration term in years. **Only affects price and registration length for `purchaseType: registration`.** Defaults to each TLD's minimum if omitted (usually 1; 2 for `.ai`). Must be a supported registration term for the TLD when `purchaseType` is `registration` (commonly 1–10 years). For `purchaseType: registration` when `purchasePrice` is required, call [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with the same `years` value. For aftermarket, expiring, and backorder types: pass the TLD default — it does **not** multiply `purchasePrice` and does **not** guarantee a multi-year registration. Check `domain.expireDate` in the create response for actual expiry. To add registration time after acquisition, use [Renew Domain](/api/v1/reference/domains/renew-domain).
     */
    #[JsonProperty('years')]
    public ?int $years;

    /**
     * @var ?string $promoCode PromoCode is an optional promotional code to apply to the domain purchase. Only one promo code can be applied per request.
     */
    #[JsonProperty('promoCode')]
    public ?string $promoCode;

    /**
     * @param array{
     *   domain: DomainCreatePayload,
     *   idempotencyKey?: ?string,
     *   purchasePrice?: ?float,
     *   purchaseType?: ?string,
     *   tldRequirements?: ?array<string, string>,
     *   claims?: ?DomainClaimsInfo,
     *   years?: ?int,
     *   promoCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'] ?? null;
        $this->domain = $values['domain'];
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->purchaseType = $values['purchaseType'] ?? null;
        $this->tldRequirements = $values['tldRequirements'] ?? null;
        $this->claims = $values['claims'] ?? null;
        $this->years = $values['years'] ?? null;
        $this->promoCode = $values['promoCode'] ?? null;
    }
}
