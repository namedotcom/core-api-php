<?php

namespace Namecom\EmailForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class EmailForwardingsUpdateEmailForwardingBody extends JsonSerializableType
{
    /**
     * @var ?string $emailTo EmailTo is the entire email address to forward email to.
     */
    #[JsonProperty('emailTo')]
    public ?string $emailTo;

    /**
     * @param array{
     *   emailTo?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->emailTo = $values['emailTo'] ?? null;
    }
}
