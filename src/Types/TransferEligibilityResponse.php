<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Result of a transfer eligibility check. Indicates whether the domain is currently registered at name.com (in any account) and whether the TLD supports internal transfer between name.com accounts.
 */
class TransferEligibilityResponse extends JsonSerializableType
{
    /**
     * @var string $domainName The domain that was checked, in its canonical (ASCII / punycode) form.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var bool $atName Whether the domain is currently registered at name.com (in any account).
     */
    #[JsonProperty('atName')]
    public bool $atName;

    /**
     * @var bool $supportsInternalTransfer Whether the TLD supports internal transfer between name.com accounts. Mirrors the TLD-level flag returned by Get Tld Requirements. Does not reflect per-account allowlist eligibility for the internal transfer-in API.
     */
    #[JsonProperty('supportsInternalTransfer')]
    public bool $supportsInternalTransfer;

    /**
     * @param array{
     *   domainName: string,
     *   atName: bool,
     *   supportsInternalTransfer: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->atName = $values['atName'];
        $this->supportsInternalTransfer = $values['supportsInternalTransfer'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
