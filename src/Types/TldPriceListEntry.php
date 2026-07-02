<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * The pricing for an individual TLD.
 *
 * Please note that if `null` is returned for any of the prices, it means that particular product is unavailable at name.com.
 *
 * For example, if `registrationPrice` returns as `null` in the response, it means that name.com is not currently accepting registrations for that TLD.
 */
class TldPriceListEntry extends JsonSerializableType
{
    /**
     * @var string $tld The TLD the pricing applies to. For IDN TLDs, this will be the unicode representation of the TLD.
     */
    #[JsonProperty('tld')]
    public string $tld;

    /**
     * @var int $duration The number of years this pricing is for
     */
    #[JsonProperty('duration')]
    public int $duration;

    /**
     * @var ?float $registrationPrice This is your account level price in US Dollars (USD) and is the price you pay for non-premium registrations. It includes applicable rebates, promotions and/or account-level discounts.
     */
    #[JsonProperty('registrationPrice')]
    public ?float $registrationPrice;

    /**
     * @var ?float $registrationRetailPrice This is the current retail price on name.com in US Dollars (USD) after including rebates, promotions and/or sales for registering non-premium domains.
     */
    #[JsonProperty('registrationRetailPrice')]
    public ?float $registrationRetailPrice;

    /**
     * @var ?float $registrationOriginalPrice This is name.com's suggested retail price (MSRP) in US Dollars (USD) before any discounts for registering non-premium domains.
     */
    #[JsonProperty('registrationOriginalPrice')]
    public ?float $registrationOriginalPrice;

    /**
     * @var ?float $renewalPrice This is your account level price in US Dollars (USD) and is the price you pay for non-premium renewals. It includes applicable rebates, promotions and/or account-level discounts.
     */
    #[JsonProperty('renewalPrice')]
    public ?float $renewalPrice;

    /**
     * @var ?float $renewalRetailPrice This is the current retail price on name.com in US Dollars (USD) after including rebates, promotions and/or sales for renewals of non-premium domains.
     */
    #[JsonProperty('renewalRetailPrice')]
    public ?float $renewalRetailPrice;

    /**
     * @var ?float $renewalOriginalPrice This is name.com's suggested retail price (MSRP) in US Dollars (USD) before any discounts for renewals of non-premium domains.
     */
    #[JsonProperty('renewalOriginalPrice')]
    public ?float $renewalOriginalPrice;

    /**
     * @var ?float $domainRestorationPrice This is your account level price in US Dollars (USD) and is the price you pay for non-premium restorations. It includes applicable rebates, promotions and/or account-level discounts.
     */
    #[JsonProperty('domainRestorationPrice')]
    public ?float $domainRestorationPrice;

    /**
     * @var ?float $domainRestorationRetailPrice This is the current retail price on name.com in US Dollars (USD) after including rebates, promotions and/or sales for restorations of non-premium domains.
     */
    #[JsonProperty('domainRestorationRetailPrice')]
    public ?float $domainRestorationRetailPrice;

    /**
     * @var ?float $domainRestorationOriginalPrice This is name.com's suggested retail price (MSRP) in US Dollars (USD) before any discounts for restoration of non-premium domains.
     */
    #[JsonProperty('domainRestorationOriginalPrice')]
    public ?float $domainRestorationOriginalPrice;

    /**
     * @var ?float $transferInPrice This is your account level price in US Dollars (USD) and is the price you pay for non-premium transfers. It includes applicable rebates, promotions and/or account-level discounts.
     */
    #[JsonProperty('transferInPrice')]
    public ?float $transferInPrice;

    /**
     * @var ?float $transferInRetailPrice This is the current retail price on name.com in US Dollars (USD) after including rebates, promotions and/or sales for transfers of non-premium domains.
     */
    #[JsonProperty('transferInRetailPrice')]
    public ?float $transferInRetailPrice;

    /**
     * @var ?float $transferInOriginalPrice This is name.com's suggested retail price (MSRP) in US Dollars (USD) before any discounts for transfer of non-premium domains.
     */
    #[JsonProperty('transferInOriginalPrice')]
    public ?float $transferInOriginalPrice;

    /**
     * @param array{
     *   tld: string,
     *   duration: int,
     *   registrationPrice?: ?float,
     *   registrationRetailPrice?: ?float,
     *   registrationOriginalPrice?: ?float,
     *   renewalPrice?: ?float,
     *   renewalRetailPrice?: ?float,
     *   renewalOriginalPrice?: ?float,
     *   domainRestorationPrice?: ?float,
     *   domainRestorationRetailPrice?: ?float,
     *   domainRestorationOriginalPrice?: ?float,
     *   transferInPrice?: ?float,
     *   transferInRetailPrice?: ?float,
     *   transferInOriginalPrice?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tld = $values['tld'];
        $this->duration = $values['duration'];
        $this->registrationPrice = $values['registrationPrice'] ?? null;
        $this->registrationRetailPrice = $values['registrationRetailPrice'] ?? null;
        $this->registrationOriginalPrice = $values['registrationOriginalPrice'] ?? null;
        $this->renewalPrice = $values['renewalPrice'] ?? null;
        $this->renewalRetailPrice = $values['renewalRetailPrice'] ?? null;
        $this->renewalOriginalPrice = $values['renewalOriginalPrice'] ?? null;
        $this->domainRestorationPrice = $values['domainRestorationPrice'] ?? null;
        $this->domainRestorationRetailPrice = $values['domainRestorationRetailPrice'] ?? null;
        $this->domainRestorationOriginalPrice = $values['domainRestorationOriginalPrice'] ?? null;
        $this->transferInPrice = $values['transferInPrice'] ?? null;
        $this->transferInRetailPrice = $values['transferInRetailPrice'] ?? null;
        $this->transferInOriginalPrice = $values['transferInOriginalPrice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
