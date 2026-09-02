<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class UpdateDomainRequest extends JsonSerializableType
{
    /**
     * @var ?bool $autorenewEnabled Enable or disable automatic renewal for the domain.
     */
    #[JsonProperty('autorenewEnabled')]
    public ?bool $autorenewEnabled;

    /**
     * @var ?bool $privacyEnabled Enable or disable Whois privacy for the domain.
     */
    #[JsonProperty('privacyEnabled')]
    public ?bool $privacyEnabled;

    /**
     * @var ?bool $locked Set the transfer lock status for the domain
     */
    #[JsonProperty('locked')]
    public ?bool $locked;

    /**
     * @param array{
     *   autorenewEnabled?: ?bool,
     *   privacyEnabled?: ?bool,
     *   locked?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->autorenewEnabled = $values['autorenewEnabled'] ?? null;
        $this->privacyEnabled = $values['privacyEnabled'] ?? null;
        $this->locked = $values['locked'] ?? null;
    }
}
