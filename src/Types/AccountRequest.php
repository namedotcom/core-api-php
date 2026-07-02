<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Account lists all the data for an account. This schema is used for requests.
 */
class AccountRequest extends JsonSerializableType
{
    /**
     * @var ?ContactsRequest $contacts Contact information associated with this account.
     */
    #[JsonProperty('contacts')]
    public ?ContactsRequest $contacts;

    /**
     * @var ?int $accountId AccountId is the unique id of account.
     */
    #[JsonProperty('accountId')]
    public ?int $accountId;

    /**
     * @var ?string $accountName AccountName is the unique name of the account.  Minimum length is 6 characters, maximum length is 60.
     */
    #[JsonProperty('accountName')]
    public ?string $accountName;

    /**
     * @var ?bool $autoRenew When set to true, domains in this account will be automatically renewed before expiration.
     */
    #[JsonProperty('autoRenew')]
    public ?bool $autoRenew;

    /**
     * @var ?DateTime $createDate CreateDate is the date the account was created.
     */
    #[JsonProperty('createDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createDate;

    /**
     * @var ?string $password Password has minimum length of 7 characters. It must contain at least 1 letter and at least 1 number/symbol.
     */
    #[JsonProperty('password')]
    public ?string $password;

    /**
     * @param array{
     *   contacts?: ?ContactsRequest,
     *   accountId?: ?int,
     *   accountName?: ?string,
     *   autoRenew?: ?bool,
     *   createDate?: ?DateTime,
     *   password?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->contacts = $values['contacts'] ?? null;
        $this->accountId = $values['accountId'] ?? null;
        $this->accountName = $values['accountName'] ?? null;
        $this->autoRenew = $values['autoRenew'] ?? null;
        $this->createDate = $values['createDate'] ?? null;
        $this->password = $values['password'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
