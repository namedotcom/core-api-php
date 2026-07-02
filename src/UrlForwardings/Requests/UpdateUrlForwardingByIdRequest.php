<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\UpdateUrlForwardingBody;

class UpdateUrlForwardingByIdRequest extends JsonSerializableType
{
    /**
     * @var UpdateUrlForwardingBody $body
     */
    public UpdateUrlForwardingBody $body;

    /**
     * @param array{
     *   body: UpdateUrlForwardingBody,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
