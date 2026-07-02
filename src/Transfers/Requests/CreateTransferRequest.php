<?php

namespace Namecom\Transfers\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class CreateTransferRequest extends JsonSerializableType
{
    /**
     * @var string $authCode AuthCode is the authorization code for the transfer. Not all TLDs require authorization codes, but most do.
     */
    #[JsonProperty('authCode')]
    public string $authCode;

    /**
     * @var string $domainName DomainName is the domain you want to transfer to name.com.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var ?bool $privacyEnabled PrivacyEnabled is a flag on whether to purchase Whois Privacy with the transfer. If this flag is omitted from the request, the system will check the account's Whois Privacy auto-add settings. If auto-add is enabled in your account settings, Whois Privacy will be added by default, provided the TLD supports it.
     */
    #[JsonProperty('privacyEnabled')]
    public ?bool $privacyEnabled;

    /**
     * @var ?float $purchasePrice PurchasePrice is the USD inbound transfer fee, before VAT. VAT is applied when applicable and must not be included here. If sent, must match Get Pricing `transferPrice` exactly or the request will fail.. **Omit** for standard (non-premium) transfers. **Required** for premium transfers — use `transferPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain).
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @param array{
     *   authCode: string,
     *   domainName: string,
     *   privacyEnabled?: ?bool,
     *   purchasePrice?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->authCode = $values['authCode'];
        $this->domainName = $values['domainName'];
        $this->privacyEnabled = $values['privacyEnabled'] ?? null;
        $this->purchasePrice = $values['purchasePrice'] ?? null;
    }
}
