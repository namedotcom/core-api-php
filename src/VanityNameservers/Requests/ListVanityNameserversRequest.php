<?php

namespace Namecom\VanityNameservers\Requests;

use Namecom\Core\Json\JsonSerializableType;

class ListVanityNameserversRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage The number of records to return per page. Defaults to 500.
     */
    public ?int $perPage;

    /**
     * @var ?int $page The page number to return.
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
