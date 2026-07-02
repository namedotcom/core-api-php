<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\UrlForwarding;

class CreateUrlForwardingRequest extends JsonSerializableType
{
    /**
     * @var UrlForwarding $body
     */
    public UrlForwarding $body;

    /**
     * @param array{
     *   body: UrlForwarding,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
