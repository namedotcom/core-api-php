<?php

namespace Namecom\Accounts\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Types\AccountRequest;
use Namecom\Core\Json\JsonProperty;

class CreateAccountRequest extends JsonSerializableType
{
    /**
     * @var AccountRequest $account The account details for the new account being created.
     */
    #[JsonProperty('account')]
    public AccountRequest $account;

    /**
     * @var bool $apiTos Must be set to true to indicate acceptance of the API Terms of Service.
     */
    #[JsonProperty('apiTos')]
    public bool $apiTos;

    /**
     * @var bool $tos Must be set to true to indicate acceptance of the general Terms of Service.
     */
    #[JsonProperty('tos')]
    public bool $tos;

    /**
     * @param array{
     *   account: AccountRequest,
     *   apiTos: bool,
     *   tos: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->account = $values['account'];
        $this->apiTos = $values['apiTos'];
        $this->tos = $values['tos'];
    }
}
