<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;
use Namecom\Core\Types\ArrayType;

/**
 * Domain contains all relevant data for a domain.
 */
class Domain extends JsonSerializableType
{
    /**
     * @var ?string $domainName The punycode-encoded value of the domain name.
     */
    #[JsonProperty('domainName')]
    public ?string $domainName;

    /**
     * @var ?DateTime $createDate The date and time when the domain was created at the registry.
     */
    #[JsonProperty('createDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createDate;

    /**
     * @var ?DateTime $expireDate The date and time when the domain will expire.
     */
    #[JsonProperty('expireDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $expireDate;

    /**
     * @var ?bool $autorenewEnabled Indicates whether the domain is set to renew automatically before expiration.
     */
    #[JsonProperty('autorenewEnabled')]
    public ?bool $autorenewEnabled;

    /**
     * @var ?bool $locked Indicates if the domain is **transfer locked**, preventing transfers to another registrar.
     */
    #[JsonProperty('locked')]
    public ?bool $locked;

    /**
     * @var ?array<string> $locks List of all registry locking statuses currently applied to the domain. Use this to see which locks are active (e.g. clientTransferProhibited, clientHold). Empty when the domain has no locks applied.
     */
    #[JsonProperty('locks'), ArrayType(['string'])]
    public ?array $locks;

    /**
     * @var ?DateTime $transferLockExpiresAt When present, the domain has an active ICANN-mandated transfer lock (new registration, transfer-in, or material registrant contact change) that blocks client unlock via the API until this time. When omitted, there is no active policy transfer lock with a known expiry — the domain may still be locked (`locked: true`) due to a voluntary user lock. Does not represent RegistrarLock, AccountLock, verification holds, trademark-claim locks, or admin TransferLock with no expiry date.
     */
    #[JsonProperty('transferLockExpiresAt'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $transferLockExpiresAt;

    /**
     * @var ?bool $privacyEnabled Indicates if Whois Privacy is enabled for this domain.
     */
    #[JsonProperty('privacyEnabled')]
    public ?bool $privacyEnabled;

    /**
     * @var ?Contacts $contacts
     */
    #[JsonProperty('contacts')]
    public ?Contacts $contacts;

    /**
     * @var ?array<string> $nameservers The list of nameservers assigned to this domain. If unspecified, it defaults to the account's default nameservers.
     */
    #[JsonProperty('nameservers'), ArrayType(['string'])]
    public ?array $nameservers;

    /**
     * @var ?float $renewalPrice The cost to renew the domain. This may be required for the RenewDomain operation.
     */
    #[JsonProperty('renewalPrice')]
    public ?float $renewalPrice;

    /**
     * @param array{
     *   domainName?: ?string,
     *   createDate?: ?DateTime,
     *   expireDate?: ?DateTime,
     *   autorenewEnabled?: ?bool,
     *   locked?: ?bool,
     *   locks?: ?array<string>,
     *   transferLockExpiresAt?: ?DateTime,
     *   privacyEnabled?: ?bool,
     *   contacts?: ?Contacts,
     *   nameservers?: ?array<string>,
     *   renewalPrice?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->domainName = $values['domainName'] ?? null;
        $this->createDate = $values['createDate'] ?? null;
        $this->expireDate = $values['expireDate'] ?? null;
        $this->autorenewEnabled = $values['autorenewEnabled'] ?? null;
        $this->locked = $values['locked'] ?? null;
        $this->locks = $values['locks'] ?? null;
        $this->transferLockExpiresAt = $values['transferLockExpiresAt'] ?? null;
        $this->privacyEnabled = $values['privacyEnabled'] ?? null;
        $this->contacts = $values['contacts'] ?? null;
        $this->nameservers = $values['nameservers'] ?? null;
        $this->renewalPrice = $values['renewalPrice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
