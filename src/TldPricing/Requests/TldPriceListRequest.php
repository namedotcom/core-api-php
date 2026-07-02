<?php

namespace Namecom\TldPricing\Requests;

use Namecom\Core\Json\JsonSerializableType;

class TldPriceListRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage Per Page is the number of records to return per request. Per Page defaults to 25.
     */
    public ?int $perPage;

    /**
     * @var ?int $page Page is which page to return.
     */
    public ?int $page;

    /**
     * @var ?int $duration The number of years to get pricing for. The requested duration must be between 1 and 10 (inclusive). If the duration is not passed in the request, it will default to 1.
     */
    public ?int $duration;

    /**
     * @var ?array<string> $tlds A list of specific TLDs to get pricing for. Maximum of 25 TLDs can be requested at a time.  When querying for IDN TLDs, due to character restrictions within a URL, they must be submitted in ASCII format.  This means using "xn--9dbq2a" as opposed to it's unicode equivalent. The submitted TLDs will be checked for validity and support at name.com, and any invalid TLD will be removed from the submitted list. If all submitted TLDs are invalid or not supported by name.com, this will be considered a bad request, and a `400 Bad Request` will be returned with an appropriate message.
     */
    public ?array $tlds;

    /**
     * @param array{
     *   perPage?: ?int,
     *   page?: ?int,
     *   duration?: ?int,
     *   tlds?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->perPage = $values['perPage'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->duration = $values['duration'] ?? null;
        $this->tlds = $values['tlds'] ?? null;
    }
}
