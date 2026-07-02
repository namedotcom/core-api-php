<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Claims acknowledgement data is required if trademark claims exist for requested domain. This data is obtained from a [Domain Claims Check](/api/v1/reference/domain-info/check-domain-claims) response and includes the claim identifier and validity dates.
 */
class DomainClaimsInfo extends JsonSerializableType
{
    /**
     * @var ?string $claimId The claim identifier from TMCH (Trademark Clearinghouse)
     */
    #[JsonProperty('claimId')]
    public ?string $claimId;

    /**
     * @var ?DateTime $notBefore The date before which the claim acknowledgment is not valid
     */
    #[JsonProperty('notBefore'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $notBefore;

    /**
     * @var ?DateTime $notAfter The date after which the claim acknowledgment expires
     */
    #[JsonProperty('notAfter'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $notAfter;

    /**
     * @param array{
     *   claimId?: ?string,
     *   notBefore?: ?DateTime,
     *   notAfter?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->claimId = $values['claimId'] ?? null;
        $this->notBefore = $values['notBefore'] ?? null;
        $this->notAfter = $values['notAfter'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
