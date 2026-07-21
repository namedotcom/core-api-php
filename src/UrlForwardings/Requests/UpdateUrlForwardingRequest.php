<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\UrlForwardingInput;

class UpdateUrlForwardingRequest extends JsonSerializableType
{
    /**
     * @var UrlForwardingInput $body
     */
    public UrlForwardingInput $body;

    /**
     * @param array{
     *   body: UrlForwardingInput,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
