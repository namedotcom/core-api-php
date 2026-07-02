<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

class PremiumDomainsDownloadResponse extends JsonSerializableType
{
    /**
     * @var ?string $downloadUrl The pre-signed URL to use to download the list.
     */
    #[JsonProperty('downloadUrl')]
    public ?string $downloadUrl;

    /**
     * @var ?DateTime $expireDate The timestamp that the URL will expire.
     */
    #[JsonProperty('expireDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $expireDate;

    /**
     * @param array{
     *   downloadUrl?: ?string,
     *   expireDate?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->downloadUrl = $values['downloadUrl'] ?? null;
        $this->expireDate = $values['expireDate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
