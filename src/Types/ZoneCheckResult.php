<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Result for checking and individual domain's presense in DNS zone files.
 */
class ZoneCheckResult extends JsonSerializableType
{
    /**
     * @var string $domainName The domain name that was checked
     */
    #[JsonProperty('domainName')]
    public string $domainName;

    /**
     * @var ?bool $available If the domain is potentially available for purchase after checking for it's presense in the DNZ zone files.
     */
    #[JsonProperty('available')]
    public ?bool $available;

    /**
     * @param array{
     *   domainName: string,
     *   available?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainName = $values['domainName'];
        $this->available = $values['available'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
