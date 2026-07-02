<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Transfer contains all relevant data for a domain transfer to name.com.
 */
class Transfer extends JsonSerializableType
{
    /**
     * @var string $domainName DomainName is the domain to be transfered to name.com.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var ?string $email Email is the email address that the approval email was sent to. Not every TLD requries an approval email. This is usually pulled from Whois.
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var value-of<TransferStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   domainName: string,
     *   status: value-of<TransferStatus>,
     *   email?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->email = $values['email'] ?? null;
        $this->status = $values['status'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
