<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\Union;
use Namecom\Core\Types\ArrayType;

/**
 * Contact role requirements (e.g., registrant, tech, admin)
 */
class ContactsRequirementFieldsValue extends JsonSerializableType
{
    /**
     * @var ?string $description Description of the contact role requirements.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?string $type The requirement type for this contact role.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var (
     *    bool
     *   |string
     * )|null $required Whether this contact role is required.
     */
    #[JsonProperty('required'), Union('bool', 'string', 'null')]
    public bool|string|null $required;

    /**
     * @var ?array<string, RequirementField> $fields Individual contact fields for this role, following RequirementField structure.
     */
    #[JsonProperty('fields'), ArrayType(['string' => RequirementField::class])]
    public ?array $fields;

    /**
     * @param array{
     *   description?: ?string,
     *   type?: ?string,
     *   required?: (
     *    bool
     *   |string
     * )|null,
     *   fields?: ?array<string, RequirementField>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->description = $values['description'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->required = $values['required'] ?? null;
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
