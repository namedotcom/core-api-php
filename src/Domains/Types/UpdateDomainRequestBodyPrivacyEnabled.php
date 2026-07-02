<?php

namespace Namecom\Domains\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class UpdateDomainRequestBodyPrivacyEnabled extends JsonSerializableType
{
    /**
     * @var bool $privacyEnabled
     */
    #[JsonProperty('privacyEnabled')]
    public bool $privacyEnabled;

    /**
     * @param array{
     *   privacyEnabled: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->privacyEnabled = $values['privacyEnabled'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
