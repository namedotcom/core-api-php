<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\Union;
use Namecom\Core\Types\ArrayType;

/**
 * ContactsRequirement defines the registration requirements for contact fields for a specific TLD, including required fields, validation rules, and conditional logic. This follows the RequirementField structure with contact roles as nested fields.
 */
class ContactsRequirement extends JsonSerializableType
{
    /**
     * @var ?string $description A detailed description of the contact requirements for this TLD, including eligibility criteria, restrictions, and important notes.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var string $type The requirement type, which will be "string" for contacts.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var (
     *    bool
     *   |string
     * ) $required Whether contact information is mandatory for domain registration.
     */
    #[JsonProperty('required'), Union('bool', 'string')]
    public bool|string $required;

    /**
     * @var ?string $label A user-friendly label for the contacts field.
     */
    #[JsonProperty('label')]
    public ?string $label;

    /**
     * @var ?array<string, ContactsRequirementFieldsValue> $fields An object containing contact roles (registrant, tech, admin, etc.) with their individual field requirements.
     */
    #[JsonProperty('fields'), ArrayType(['string' => ContactsRequirementFieldsValue::class])]
    public ?array $fields;

    /**
     * @param array{
     *   type: string,
     *   required: (
     *    bool
     *   |string
     * ),
     *   description?: ?string,
     *   label?: ?string,
     *   fields?: ?array<string, ContactsRequirementFieldsValue>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->description = $values['description'] ?? null;
        $this->type = $values['type'];
        $this->required = $values['required'];
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
