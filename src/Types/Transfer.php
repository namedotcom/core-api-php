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
     * @var value-of<TransferStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   domainName: string,
     *   status: value-of<TransferStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
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
