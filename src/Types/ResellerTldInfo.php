<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * General information about a TLD and it's various requirements. This is not a comprehensive list of all information related to a TLD.
 */
class ResellerTldInfo extends JsonSerializableType
{
    /**
     * @var string $tld The TLD this information relates to.
     */
    #[JsonProperty('tld')]
    public string $tld;

    /**
     * @var bool $ccTld Whether the TLD is a Country Code TLD.
     */
    #[JsonProperty('ccTld')]
    public bool $ccTld;

    /**
     * @var bool $supportsTransferLock Whether the TLD supports implementing a Transfer Lock.
     */
    #[JsonProperty('supportsTransferLock')]
    public bool $supportsTransferLock;

    /**
     * @var bool $supportsDnssec Whether the TLD supports DNSSEC.
     */
    #[JsonProperty('supportsDnssec')]
    public bool $supportsDnssec;

    /**
     * @var bool $supportsPremium Whether there are premium domains for this TLD.
     */
    #[JsonProperty('supportsPremium')]
    public bool $supportsPremium;

    /**
     * @var bool $supportsPrivacy Whether the TLD supports WHOIS Privacy.
     */
    #[JsonProperty('supportsPrivacy')]
    public bool $supportsPrivacy;

    /**
     * @var bool $supportsInternalTransfer Whether the TLD supports internal transfer between reseller accounts.
     */
    #[JsonProperty('supportsInternalTransfer')]
    public bool $supportsInternalTransfer;

    /**
     * @var bool $requiresPreDelegation Whether this TLD requires pre-delegation. If this is true, these domains must be added to the name servers before the domain creation is completed.
     */
    #[JsonProperty('requiresPreDelegation')]
    public bool $requiresPreDelegation;

    /**
     * @var int $expirationGracePeriod The number of days you have to renew your domain after it has expired, but before it is removed from your account.
     */
    #[JsonProperty('expirationGracePeriod')]
    public int $expirationGracePeriod;

    /**
     * @var array<int> $allowedRegistrationYears The years that a domain is allowed to be registered for.
     */
    #[JsonProperty('allowedRegistrationYears'), ArrayType(['integer'])]
    public array $allowedRegistrationYears;

    /**
     * @var array<string, string> $idnLanguages The IND Languages that the TLD supports (if any).
     */
    #[JsonProperty('idnLanguages'), ArrayType(['string' => 'string'])]
    public array $idnLanguages;

    /**
     * @var bool $hsts The entire TLD namespace has been added to the HSTS Preload list. As such, all second-level domains under .TLD will only load on modern browsers if a valid SSL certificate has been configured and the webserver is serving HTTPS.
     */
    #[JsonProperty('hsts')]
    public bool $hsts;

    /**
     * @var int $minDomainLength The minimum allowed length for the second level domain (SLD) for a given TLD. The SLD would be the `example` part of `example.com`. Attempts to register a domain with a shorter length than allowed will result in a failure of a Create Domain request.
     */
    #[JsonProperty('minDomainLength')]
    public int $minDomainLength;

    /**
     * @var ?int $minIdnDomainLength The minimum allowed length for the second level domain (SLD) that utilizes an IDN character for a given TLD.  The SLD would be the `èxample` part of `èxample.com`. Attempts to register a domain with a shorter length than allowed will result in a failure of a Create Domain request. This value will often be different from the `minDomainLength` for non-IDN registrations.  This parameter will return as `null` for any TLDs that do not support IDN registrations.
     */
    #[JsonProperty('minIdnDomainLength')]
    public ?int $minIdnDomainLength;

    /**
     * @var string $registryOperator The registry that operates the given TLD.
     */
    #[JsonProperty('registryOperator')]
    public string $registryOperator;

    /**
     * @var array<value-of<ResellerTldInfoClaimsCheckRequiredItem>> $claimsCheckRequired Array of valid purchase types if claims check is required for this TLD for current date/time.  If claims checking is required, returns an array of valid purchase types (e.g., ["registration", "landrush_eap"]).  If claims checking is not required, returns an empty array [].
     */
    #[JsonProperty('claimsCheckRequired'), ArrayType(['string'])]
    public array $claimsCheckRequired;

    /**
     * @var bool $requireIdnSld When true, the TLD only accepts IDN (punycode) second-level domain names in the required script. ASCII/Latin SLDs are not valid for registration.
     */
    #[JsonProperty('requireIdnSld')]
    public bool $requireIdnSld;

    /**
     * @param array{
     *   tld: string,
     *   ccTld: bool,
     *   supportsTransferLock: bool,
     *   supportsDnssec: bool,
     *   supportsPremium: bool,
     *   supportsPrivacy: bool,
     *   supportsInternalTransfer: bool,
     *   requiresPreDelegation: bool,
     *   expirationGracePeriod: int,
     *   allowedRegistrationYears: array<int>,
     *   idnLanguages: array<string, string>,
     *   hsts: bool,
     *   minDomainLength: int,
     *   registryOperator: string,
     *   claimsCheckRequired: array<value-of<ResellerTldInfoClaimsCheckRequiredItem>>,
     *   requireIdnSld: bool,
     *   minIdnDomainLength?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tld = $values['tld'];
        $this->ccTld = $values['ccTld'];
        $this->supportsTransferLock = $values['supportsTransferLock'];
        $this->supportsDnssec = $values['supportsDnssec'];
        $this->supportsPremium = $values['supportsPremium'];
        $this->supportsPrivacy = $values['supportsPrivacy'];
        $this->supportsInternalTransfer = $values['supportsInternalTransfer'];
        $this->requiresPreDelegation = $values['requiresPreDelegation'];
        $this->expirationGracePeriod = $values['expirationGracePeriod'];
        $this->allowedRegistrationYears = $values['allowedRegistrationYears'];
        $this->idnLanguages = $values['idnLanguages'];
        $this->hsts = $values['hsts'];
        $this->minDomainLength = $values['minDomainLength'];
        $this->minIdnDomainLength = $values['minIdnDomainLength'] ?? null;
        $this->registryOperator = $values['registryOperator'];
        $this->claimsCheckRequired = $values['claimsCheckRequired'];
        $this->requireIdnSld = $values['requireIdnSld'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
