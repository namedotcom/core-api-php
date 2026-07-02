<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

/**
 * A JSON Schema Draft 7 document that describes the registration requirements for a TLD. This schema follows the JSON Schema Draft 7 specification (http://json-schema.org/draft-07/schema#) and can be used directly by form generation and validation libraries that consume JSON Schema.
 * The schema structure includes: - A `tldInfo` property containing general TLD information (read-only, always present) - A `contacts` property containing contact field requirements (e.g., registrant, admin, tech) - A `tldRequirements` property containing TLD-specific registration fields
 * The `contacts` and `tldRequirements` properties may be empty objects, while `tldInfo` will always contain data. The exact structure varies by TLD, as different TLDs have different registration requirements.
 */
class RequirementsJsonSchema extends JsonSerializableType
{
    /**
     * @var ?string $schema The JSON Schema version identifier, should be "http://json-schema.org/draft-07/schema#"
     */
    #[JsonProperty('$schema')]
    public ?string $schema;

    /**
     * @var ?string $type The JSON Schema type, typically "object" for requirement schemas
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?string $title A human-readable title for the schema
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var ?string $description A detailed description of the registration requirements
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?RequirementsJsonSchemaProperties $properties An object containing the schema properties. Includes: - `tldInfo`: An object containing general TLD information (read-only) - `contacts`: An object defining contact field requirements - `tldRequirements`: An object defining TLD-specific registration fields
     */
    #[JsonProperty('properties')]
    public ?RequirementsJsonSchemaProperties $properties;

    /**
     * @var ?array<string> $required An array of required property names
     */
    #[JsonProperty('required'), ArrayType(['string'])]
    public ?array $required;

    /**
     * @var ?array<array<string, mixed>> $allOf An array of schema objects that must all be valid. Used for conditional validation with multiple conditions.
     */
    #[JsonProperty('allOf'), ArrayType([['string' => 'mixed']])]
    public ?array $allOf;

    /**
     * @var ?array<string, mixed> $if The condition schema for conditional validation. When this condition is true, the 'then' schema applies.
     */
    #[JsonProperty('if'), ArrayType(['string' => 'mixed'])]
    public ?array $if;

    /**
     * @var ?array<string, mixed> $then The schema to apply when the 'if' condition is true.
     */
    #[JsonProperty('then'), ArrayType(['string' => 'mixed'])]
    public ?array $then;

    /**
     * @var ?array<string, mixed> $else The schema to apply when the 'if' condition is false (optional).
     */
    #[JsonProperty('else'), ArrayType(['string' => 'mixed'])]
    public ?array $else;

    /**
     * @param array{
     *   schema?: ?string,
     *   type?: ?string,
     *   title?: ?string,
     *   description?: ?string,
     *   properties?: ?RequirementsJsonSchemaProperties,
     *   required?: ?array<string>,
     *   allOf?: ?array<array<string, mixed>>,
     *   if?: ?array<string, mixed>,
     *   then?: ?array<string, mixed>,
     *   else?: ?array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->schema = $values['schema'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->properties = $values['properties'] ?? null;
        $this->required = $values['required'] ?? null;
        $this->allOf = $values['allOf'] ?? null;
        $this->if = $values['if'] ?? null;
        $this->then = $values['then'] ?? null;
        $this->else = $values['else'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
