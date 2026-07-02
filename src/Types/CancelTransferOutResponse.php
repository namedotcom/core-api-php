<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Response after successfully canceling a domain transfer out request.
 */
class CancelTransferOutResponse extends JsonSerializableType
{
    /**
     * @var string $domainName The punycode-encoded domain name.
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var value-of<CancelTransferOutResponseStatus> $status The transfer-out status after the operation (e.g. canceled when the cancel succeeded).
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   domainName: string,
     *   status: value-of<CancelTransferOutResponseStatus>,
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
