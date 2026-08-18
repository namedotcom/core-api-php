<?php

namespace Namecom\ContactVerification\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\EmptyObject;

class ResendContactVerificationEmailRequest extends JsonSerializableType
{
    /**
     * @var EmptyObject $body
     */
    public EmptyObject $body;

    /**
     * @param array{
     *   body: EmptyObject,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
