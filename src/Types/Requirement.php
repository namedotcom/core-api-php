<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * Requirement defines the registration requirements for a specific TLD, including required fields, validation rules, and conditional logic.
 */
class Requirement extends JsonSerializableType
{
    /**
     * @var ?string $description A detailed description of the registration requirements for this TLD, including eligibility criteria, restrictions, and important notes.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?array<string, RequirementField> $fields An object containing all required and optional fields for domain registration, with their validation rules and conditional logic.
     */
    #[JsonProperty('fields'), ArrayType(['string' => RequirementField::class])]
    public ?array $fields;

    /**
     * @param array{
     *   description?: ?string,
     *   fields?: ?array<string, RequirementField>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->description = $values['description'] ?? null;
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
