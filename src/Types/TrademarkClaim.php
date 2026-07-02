<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Information about a specific trademark claim
 */
class TrademarkClaim extends JsonSerializableType
{
    /**
     * @var string $trademark The trademark text that matches the domain
     */
    #[JsonProperty('trademark')]
    public string $trademark;

    /**
     * @var string $holder The entity that holds the trademark
     */
    #[JsonProperty('holder')]
    public string $holder;

    /**
     * @var ?string $jurisdiction The jurisdiction where the trademark is registered
     */
    #[JsonProperty('jurisdiction')]
    public ?string $jurisdiction;

    /**
     * @var ?string $registrationNumber The trademark registration number
     */
    #[JsonProperty('registrationNumber')]
    public ?string $registrationNumber;

    /**
     * @var ?string $description Additional description of the trademark
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?string $noticeHtml HTML content to display about this specific trademark claim
     */
    #[JsonProperty('noticeHtml')]
    public ?string $noticeHtml;

    /**
     * @var ?float $confidence Confidence score for the trademark match (0.0 to 1.0)
     */
    #[JsonProperty('confidence')]
    public ?float $confidence;

    /**
     * @param array{
     *   trademark: string,
     *   holder: string,
     *   jurisdiction?: ?string,
     *   registrationNumber?: ?string,
     *   description?: ?string,
     *   noticeHtml?: ?string,
     *   confidence?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->trademark = $values['trademark'];
        $this->holder = $values['holder'];
        $this->jurisdiction = $values['jurisdiction'] ?? null;
        $this->registrationNumber = $values['registrationNumber'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->noticeHtml = $values['noticeHtml'] ?? null;
        $this->confidence = $values['confidence'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
