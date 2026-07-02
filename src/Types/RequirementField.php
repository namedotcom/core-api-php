<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\Union;
use Namecom\Core\Types\ArrayType;

/**
 * A field definition for TLD registration requirements, including validation rules, conditional logic, and nested field structures.
 */
class RequirementField extends JsonSerializableType
{
    /**
     * @var ?string $description A detailed description of what this field is for and any specific requirements or constraints.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * The requirement type of this field. Each requirement type has different information.
     *
     * Possible values and their details:
     *
     *   - **`string`**: These are open string fields that cannot be submitted as empty. They will always have a label. A description is optional as the label may convey all of the required information the user would need to submit.
     *       Note: Some string fields may have a required format (i.e. date format of YYYY/MM/DD). The format will be listed in the "validation" parameter if required.
     *       Example TLDs: abogado, law, com.br (and more)
     *
     *   - **`notice`**: These field types will just have a description, and contain information that must be displayed to the user prior to registration. There is no data that will be required to be submitted, so all notice type fields will have a "required" value of `false`.
     *       Example TLDs: at (notice only), ca (1 notice field)
     *
     *   - **`acknowledgement`**: These field types will have a description, label and value. The description must be displayed to the user, the label is the required label for the acknowledgement, and the value is what must be submitted.
     *       Example TLDs: security, ngo, music (and more)
     *
     *   - **`enum`**: The field types have a list of predefined options that the user must choose from in order to submit. Only the values returned in the "options" array will be allowed, or the request will fail validation. Options MAY include dependent fields, as some registries required additional information depending on what was chosen for the "parent" option. All dependent fields will follow the same field patterns as the parent fields.
     *       Options: These are the predefined options for the enum type fields. They will always have a label and a value. The value is what must be submitted. The options MAY include a description, but will mostly only have a label parameter.
     *       Note: There may be a single option returned for an enum. This is because that is the ONLY OPTION ALLOWED by the registry.
     *       Example TLDs with simple lists: ca, es (and more)
     *       Example TLDs with dependent fields: fr, se, com.br
     *
     *   - **`boolean`**: Boolean fields for simple true/false acknowledgements or selections.
     *       Example TLDs: security
     *
     * @var value-of<RequirementFieldType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var (
     *    bool
     *   |string
     * ) $required Whether this field is mandatory for domain registration. If true, the field must be provided.
     */
    #[JsonProperty('required'), Union('bool', 'string')]
    public bool|string $required;

    /**
     * @var ?string $label A user-friendly label for this field that can be used in UI forms.
     */
    #[JsonProperty('label')]
    public ?string $label;

    /**
     * @var ?string $validation Validation rule to apply to this field. Common validations include 'valid_email', 'valid_phone', etc.
     */
    #[JsonProperty('validation')]
    public ?string $validation;

    /**
     * @var (
     *    array<RequirementFieldOption>
     *   |array<string>
     * )|null $options For fields with predefined choices, this can be either an array of complex option objects, a simple array of string values, or null if no options are available.
     */
    #[JsonProperty('options'), Union([RequirementFieldOption::class], ['string'], 'null')]
    public array|null $options;

    /**
     * @var ?string $requiredWhen For conditional fields, specifies when this field becomes required (e.g., when a parent option has a specific value).
     */
    #[JsonProperty('required_when')]
    public ?string $requiredWhen;

    /**
     * @var ?array<string, ?RequirementField> $fields For complex fields or when options are selected, contains nested field definitions that become relevant.
     */
    #[JsonProperty('fields'), ArrayType(['string' => new Union(RequirementField::class, 'null')])]
    public ?array $fields;

    /**
     * @var ?string $value For acknowledgement fields, this is the value that must be submitted when the user acknowledges the requirement.
     */
    #[JsonProperty('value')]
    public ?string $value;

    /**
     * @param array{
     *   type: value-of<RequirementFieldType>,
     *   required: (
     *    bool
     *   |string
     * ),
     *   description?: ?string,
     *   label?: ?string,
     *   validation?: ?string,
     *   options?: (
     *    array<RequirementFieldOption>
     *   |array<string>
     * )|null,
     *   requiredWhen?: ?string,
     *   fields?: ?array<string, ?RequirementField>,
     *   value?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->description = $values['description'] ?? null;
        $this->type = $values['type'];
        $this->required = $values['required'];
        $this->label = $values['label'] ?? null;
        $this->validation = $values['validation'] ?? null;
        $this->options = $values['options'] ?? null;
        $this->requiredWhen = $values['requiredWhen'] ?? null;
        $this->fields = $values['fields'] ?? null;
        $this->value = $values['value'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
