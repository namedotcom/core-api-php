<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Domains\Types\UpdateDomainRequestBodyAutorenewEnabled;
use Namecom\Domains\Types\UpdateDomainRequestBodyPrivacyEnabled;
use Namecom\Domains\Types\UpdateDomainRequestBodyLocked;

class UpdateDomainRequest extends JsonSerializableType
{
    /**
     * @var (
     *    UpdateDomainRequestBodyAutorenewEnabled
     *   |UpdateDomainRequestBodyPrivacyEnabled
     *   |UpdateDomainRequestBodyLocked
     * ) $body
     */
    public UpdateDomainRequestBodyAutorenewEnabled|UpdateDomainRequestBodyPrivacyEnabled|UpdateDomainRequestBodyLocked $body;

    /**
     * @param array{
     *   body: (
     *    UpdateDomainRequestBodyAutorenewEnabled
     *   |UpdateDomainRequestBodyPrivacyEnabled
     *   |UpdateDomainRequestBodyLocked
     * ),
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
