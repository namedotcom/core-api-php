<?php

namespace Namecom\DomainInfo\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\DomainInfo\Types\DomainClaimsCheckRequestPurchaseType;
use Namecom\Core\Json\JsonProperty;

class DomainClaimsCheckRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<DomainClaimsCheckRequestPurchaseType> $purchaseType The type of purchase/registration for which to check claims. Defaults to 'registration'. Other values like 'landrush_eap', 'landrush_auction_a', 'landrush_reserve_a' may be used during new gTLD launches.
     */
    #[JsonProperty('purchaseType')]
    public ?string $purchaseType;

    /**
     * @param array{
     *   purchaseType?: ?value-of<DomainClaimsCheckRequestPurchaseType>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->purchaseType = $values['purchaseType'] ?? null;
    }
}
