<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * An object containing the schema properties. Includes: - `tldInfo`: An object containing general TLD information (read-only) - `contacts`: An object defining contact field requirements - `tldRequirements`: An object defining TLD-specific registration fields
 */
class RequirementsJsonSchemaProperties extends JsonSerializableType
{
    /**
     * @var ?ResellerTldInfo $tldInfo General information about a TLD and it's various requirements. This is not a comprehensive list of all information related to a TLD.  The structure matches ResellerTldInfo schema. In JSON Schema document examples, this property will contain a schema definition object  with `allOf` referencing ResellerTldInfo and `readOnly: true`.
     */
    #[JsonProperty('tldInfo')]
    public ?ResellerTldInfo $tldInfo;

    /**
     * @var ?array<string, mixed> $contacts An object defining contact field requirements. May be an empty object if no contact requirements exist for the TLD.
     */
    #[JsonProperty('contacts'), ArrayType(['string' => 'mixed'])]
    public ?array $contacts;

    /**
     * @var ?array<string, mixed> $tldRequirements An object defining TLD-specific registration fields. May be an empty object if no TLD-specific requirements exist.
     */
    #[JsonProperty('tldRequirements'), ArrayType(['string' => 'mixed'])]
    public ?array $tldRequirements;

    /**
     * @param array{
     *   tldInfo?: ?ResellerTldInfo,
     *   contacts?: ?array<string, mixed>,
     *   tldRequirements?: ?array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tldInfo = $values['tldInfo'] ?? null;
        $this->contacts = $values['contacts'] ?? null;
        $this->tldRequirements = $values['tldRequirements'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
