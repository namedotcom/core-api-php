<?php

namespace Namecom\Transfers\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Types\ContactsRequest;

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
     * @var ?bool $privacyEnabled Whether to include Whois Privacy with the transfer. Whois Privacy is free. If omitted, the account default from account settings is used. Privacy is only added when the TLD supports it.
     */
    #[JsonProperty('privacyEnabled')]
    public ?bool $privacyEnabled;

    /**
     * @var ?float $purchasePrice PurchasePrice is the USD inbound transfer fee, before VAT. VAT is applied when applicable and must not be included here. If sent, must match Get Pricing `transferPrice` exactly or the request will fail.. **Omit** for standard (non-premium) transfers. **Required** for premium transfers — use `transferPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain).
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?ContactsRequest $contacts WHOIS contacts to apply when the domain lands in the account. If omitted, the gaining account's default contacts are applied. If provided, include any roles to override; omitted roles use the gaining account's default contacts. Each supplied role must include complete contact fields. A registrar contact-change transfer lock may apply according to the gaining account's settings.
     */
    #[JsonProperty('contacts')]
    public ?ContactsRequest $contacts;

    /**
     * @param array{
     *   authCode: string,
     *   domainName: string,
     *   privacyEnabled?: ?bool,
     *   purchasePrice?: ?float,
     *   contacts?: ?ContactsRequest,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->authCode = $values['authCode'];
        $this->domainName = $values['domainName'];
        $this->privacyEnabled = $values['privacyEnabled'] ?? null;
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->contacts = $values['contacts'] ?? null;
    }
}
