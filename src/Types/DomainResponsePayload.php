<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;
use Namecom\Core\Types\ArrayType;

/**
 * The response format for a domain.
 */
class DomainResponsePayload extends JsonSerializableType
{
    /**
     * @var string $domainName
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var ?DateTime $createDate
     */
    #[JsonProperty('createDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createDate;

    /**
     * @var ?DateTime $expireDate
     */
    #[JsonProperty('expireDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $expireDate;

    /**
     * @var bool $autorenewEnabled
     */
    #[JsonProperty('autorenewEnabled')]
    public bool $autorenewEnabled;

    /**
     * @var bool $locked
     */
    #[JsonProperty('locked')]
    public bool $locked;

    /**
     * @var ?DateTime $transferLockExpiresAt
     */
    #[JsonProperty('transferLockExpiresAt'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $transferLockExpiresAt;

    /**
     * @var bool $privacyEnabled
     */
    #[JsonProperty('privacyEnabled')]
    public bool $privacyEnabled;

    /**
     * @var array<string> $nameservers
     */
    #[JsonProperty('nameservers'), ArrayType(['string'])]
    public array $nameservers;

    /**
     * @var ?float $renewalPrice
     */
    #[JsonProperty('renewalPrice')]
    public ?float $renewalPrice;

    /**
     * @var ?array<string> $locks List of all registry locking statuses currently applied to the domain. Use this to see which locks are active (e.g. clientTransferProhibited, clientHold). Empty when the domain has no locks applied.
     */
    #[JsonProperty('locks'), ArrayType(['string'])]
    public ?array $locks;

    /**
     * @var ?Contacts $contacts
     */
    #[JsonProperty('contacts')]
    public ?Contacts $contacts;

    /**
     * @param array{
     *   domainName: string,
     *   autorenewEnabled: bool,
     *   locked: bool,
     *   privacyEnabled: bool,
     *   nameservers: array<string>,
     *   createDate?: ?DateTime,
     *   expireDate?: ?DateTime,
     *   transferLockExpiresAt?: ?DateTime,
     *   renewalPrice?: ?float,
     *   locks?: ?array<string>,
     *   contacts?: ?Contacts,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->createDate = $values['createDate'] ?? null;
        $this->expireDate = $values['expireDate'] ?? null;
        $this->autorenewEnabled = $values['autorenewEnabled'];
        $this->locked = $values['locked'];
        $this->transferLockExpiresAt = $values['transferLockExpiresAt'] ?? null;
        $this->privacyEnabled = $values['privacyEnabled'];
        $this->nameservers = $values['nameservers'];
        $this->renewalPrice = $values['renewalPrice'] ?? null;
        $this->locks = $values['locks'] ?? null;
        $this->contacts = $values['contacts'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
