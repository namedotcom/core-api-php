<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * EmailForwarding contains all the information for an email forwarding entry.
 */
class EmailForwarding extends JsonSerializableType
{
    /**
     * @var string $domainName DomainName is the domain part of the email address to forward.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var string $emailBox EmailBox is the user portion of the email address to forward.
     */
    #[JsonProperty('emailBox')]
    public string $emailBox;

    /**
     * @var string $emailTo EmailTo is the entire email address to forward email to.
     */
    #[JsonProperty('emailTo')]
    public string $emailTo;

    /**
     * @param array{
     *   domainName: string,
     *   emailBox: string,
     *   emailTo: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->emailBox = $values['emailBox'];
        $this->emailTo = $values['emailTo'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
