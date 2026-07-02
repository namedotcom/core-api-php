<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;

class GetPricingForDomainRequest extends JsonSerializableType
{
    /**
     * @var ?int $years Years specifies the registration term to price in years. Defaults to each TLD's minimum registration term if omitted — usually 1 year (2 for `.ai`). Must be a supported registration term for the TLD (commonly 1–10 years). Use the same value on Create Domain when passing `purchasePrice` for `purchaseType: registration`.
     */
    public ?int $years;

    /**
     * @param array{
     *   years?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->years = $values['years'] ?? null;
    }
}
