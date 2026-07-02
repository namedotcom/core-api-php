<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * This endpoint retrieves the transfer authorization code (EPP code) for qualifying domains. Locks may exist on a domain that can prevent the initiation of a transfer request, despite an auth code being returned by the API.  Use the [Get Domain](/api/v1/reference/domains/get-domain) API to check the lock status of a domain. A Create Transfer request for a locked domain will return an error.
 */
class AuthCodeResponse extends JsonSerializableType
{
    /**
     * @var string $authCode AuthCode is the authorization code needed to transfer a domain to another registrar. If you are storing auth codes, be sure to store them in a secure manner.
     */
    #[JsonProperty('authCode')]
    public string $authCode;

    /**
     * @param array{
     *   authCode: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->authCode = $values['authCode'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
