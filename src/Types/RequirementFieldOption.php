<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;
use Namecom\Core\Types\Union;

/**
 * An option within a field that has predefined choices, including the option value, label, and any nested fields that become relevant when this option is selected.
 */
class RequirementFieldOption extends JsonSerializableType
{
    /**
     * @var string $value The actual value of this option. This is what must be submitted when this option is selected.
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @var ?string $label A user-friendly label for this option that can be displayed in UI forms.
     */
    #[JsonProperty('label')]
    public ?string $label;

    /**
     * @var ?array<string, ?RequirementField> $fields When this option is selected, these nested fields become relevant and may be required. This allows for conditional field logic.
     */
    #[JsonProperty('fields'), ArrayType(['string' => new Union(RequirementField::class, 'null')])]
    public ?array $fields;

    /**
     * @param array{
     *   value: string,
     *   label?: ?string,
     *   fields?: ?array<string, ?RequirementField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->value = $values['value'];
        $this->label = $values['label'] ?? null;
        $this->fields = $values['fields'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
