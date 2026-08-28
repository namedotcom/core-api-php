<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\UrlForwardingUpdate;

class UpdateUrlForwardingByIdRequest extends JsonSerializableType
{
    /**
     * @var UrlForwardingUpdate $body
     */
    public UrlForwardingUpdate $body;

    /**
     * @param array{
     *   body: UrlForwardingUpdate,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
