<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class DomainsPurchasePrivacyBody extends JsonSerializableType
{
    /**
     * @var ?float $purchasePrice WHOIS privacy is free for API users. This field does not add a privacy fee.
     */
    #[JsonProperty('purchasePrice')]
    public ?float $purchasePrice;

    /**
     * @var ?int $years Years is the number of years to enable or extend Whois Privacy for. Years defaults to 1 and cannot be more then the domain expiration date.
     */
    #[JsonProperty('years')]
    public ?int $years;

    /**
     * @param array{
     *   purchasePrice?: ?float,
     *   years?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->purchasePrice = $values['purchasePrice'] ?? null;
        $this->years = $values['years'] ?? null;
    }
}
