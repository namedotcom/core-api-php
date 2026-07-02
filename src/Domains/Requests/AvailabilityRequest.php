<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;
use Namecom\Types\SearchPurchaseType;

class AvailabilityRequest extends JsonSerializableType
{
    /**
     * @var array<string> $domainNames DomainNames is the list of domains to check if they are available.
     */
    #[JsonProperty('domainNames'), ArrayType(['string'])]
    public array $domainNames;

    /**
     * @var ?value-of<SearchPurchaseType> $purchaseType Optional filter. **Recommended:** `registration` for most integrations — omit only if you support acquisition types. Non-matching domains are returned with `purchasable: false` (Search omits them instead). See the [Domain purchase pricing guide](/guides/domain-pricing).
     */
    #[JsonProperty('purchaseType')]
    public ?string $purchaseType;

    /**
     * @param array{
     *   domainNames: array<string>,
     *   purchaseType?: ?value-of<SearchPurchaseType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainNames = $values['domainNames'];
        $this->purchaseType = $values['purchaseType'] ?? null;
    }
}
