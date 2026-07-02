<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * CreateAccountResponse contains information about the newly created account and the API credentials generated for it.
 */
class CreateAccountResponse extends JsonSerializableType
{
    /**
     * @var string $accountName AccountName is the unique user-assigned name of newly created account.
     */
    #[JsonProperty('accountName')]
    public string $accountName;

    /**
     * @var string $apiToken The authentication token that should be used to access the API. This value is only returned once upon account creation.
     */
    #[JsonProperty('apiToken')]
    public string $apiToken;

    /**
     * @var string $apiTokenName ApiTokenName user assigned name of api token.
     */
    #[JsonProperty('apiTokenName')]
    public string $apiTokenName;

    /**
     * @param array{
     *   accountName: string,
     *   apiToken: string,
     *   apiTokenName: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountName = $values['accountName'];
        $this->apiToken = $values['apiToken'];
        $this->apiTokenName = $values['apiTokenName'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
