<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;
use DateTime;
use Namecom\Core\Types\Date;

/**
 * Response containing domain-specific claims data and trademark information
 */
class DomainClaimsCheckResponse extends JsonSerializableType
{
    /**
     * @var string $domain The domain name that was checked for claims
     */
    #[JsonProperty('domain')]
    public string $domain;

    /**
     * @var array<TrademarkClaim> $claims List of trademark claims found against this domain
     */
    #[JsonProperty('claims'), ArrayType([TrademarkClaim::class])]
    public array $claims;

    /**
     * @var ?bool $claimsProcessActive Whether the TLD of this domain requires claims checking
     */
    #[JsonProperty('claimsProcessActive')]
    public ?bool $claimsProcessActive;

    /**
     * @var ?string $claimId The claim identifier from TMCH (null if no claims found)
     */
    #[JsonProperty('claimId')]
    public ?string $claimId;

    /**
     * @var ?DateTime $notBefore The date before which the claim acknowledgment is not valid (null if no claims found)
     */
    #[JsonProperty('notBefore'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $notBefore;

    /**
     * @var ?DateTime $notAfter The date after which the claim acknowledgment expires (null if no claims found)
     */
    #[JsonProperty('notAfter'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $notAfter;

    /**
     * @var ?string $claimsNotice Markdown content to display about this specific trademark claim
     */
    #[JsonProperty('claimsNotice')]
    public ?string $claimsNotice;

    /**
     * @param array{
     *   domain: string,
     *   claims: array<TrademarkClaim>,
     *   claimsProcessActive?: ?bool,
     *   claimId?: ?string,
     *   notBefore?: ?DateTime,
     *   notAfter?: ?DateTime,
     *   claimsNotice?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domain = $values['domain'];
        $this->claims = $values['claims'];
        $this->claimsProcessActive = $values['claimsProcessActive'] ?? null;
        $this->claimId = $values['claimId'] ?? null;
        $this->notBefore = $values['notBefore'] ?? null;
        $this->notAfter = $values['notAfter'] ?? null;
        $this->claimsNotice = $values['claimsNotice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
