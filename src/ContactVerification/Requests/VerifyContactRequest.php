<?php

namespace Namecom\ContactVerification\Requests;

use Namecom\Core\Json\JsonSerializableType;

class VerifyContactRequest extends JsonSerializableType
{
    /**
     * @var ?string $idempotencyKey A unique string (e.g., a UUID v4) to make the request idempotent. This key ensures that if the request is retried, the operation will not be performed multiple times. Subsequent requests with the same key will return the original result.
     */
    public ?string $idempotencyKey;

    /**
     * @param array{
     *   idempotencyKey?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->idempotencyKey = $values['idempotencyKey'] ?? null;
    }
}
