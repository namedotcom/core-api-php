<?php

namespace Namecom\ContactVerification\Requests;

use Namecom\Core\Json\JsonSerializableType;

class UnverifiedContactsListRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage PerPage is the number of records to return per request. If not passed in the request, the default value is 100 records.
     */
    public ?int $perPage;

    /**
     * @var ?int $page Page is which page to return. If not passed in the request, the default page is 1.
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
