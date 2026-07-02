<?php

namespace Namecom\EmailForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class CreateEmailForwardingRequest extends JsonSerializableType
{
    /**
     * @var string $emailBox EmailBox is the user portion of the email address to forward. If your email is "admin@example.com", it would just be "admin"
     */
    #[JsonProperty('emailBox')]
    public string $emailBox;

    /**
     * @var string $emailTo EmailTo is the entire email address to forward email to.
     */
    #[JsonProperty('emailTo')]
    public string $emailTo;

    /**
     * @param array{
     *   emailBox: string,
     *   emailTo: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->emailBox = $values['emailBox'];
        $this->emailTo = $values['emailTo'];
    }
}
