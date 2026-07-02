<?php

namespace Namecom\EmailForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;

class ListEmailForwardingsRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage (optional) Per Page is the number of records to return per request. Per Page defaults to 500 if not set.
     */
    public ?int $perPage;

    /**
     * @var ?int $page (optional) Page is which page to return. Default to page 1 if not set.
     */
    public ?int $page;

    /**
     * @param array{
     *   perPage?: ?int,
     *   page?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->perPage = $values['perPage'] ?? null;
        $this->page = $values['page'] ?? null;
    }
}
