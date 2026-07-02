<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

class TooManyRequestsErrorBody extends JsonSerializableType
{
    /**
     * ### Too Many Requests
     * You have exceeded the rate limit.
     *
     * **Headers returned:**
     * * 'X-RateLimit-Reset': An integer (UTC epoch) indicating when you can retry.
     *
     * @var string $message
     */
    #[JsonProperty('message')]
    public string $message;

    /**
     * @param array{
     *   message: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->message = $values['message'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
