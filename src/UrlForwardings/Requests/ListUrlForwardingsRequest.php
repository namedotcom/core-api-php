<?php

namespace Namecom\UrlForwardings\Requests;

use Namecom\Core\Json\JsonSerializableType;

class ListUrlForwardingsRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage Per Page is the number of records to return per request. Per Page defaults to 500.
     */
    public ?int $perPage;

    /**
     * @var ?int $page Page is which page to return. Starts at 1 for first page.
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
